<?php

namespace Tests\Feature;

use App\Models\Trademarks;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TrademarkFileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // A disposable database; these tests never migrate or write the user's database.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('trademark', function (Blueprint $table) {
            $table->id();
            foreach (array_unique(array_merge((new Trademarks())->getFillable(), ['id_holder', 'address_holder'])) as $field) {
                $table->text($field)->nullable();
            }
        });
        foreach ([
            'clients' => ['company_name'],
            'holder' => ['company_name'],
            'contact_clients' => ['id_client', 'name', 'email'],
            'adress_clients' => ['id_clients', 'address', 'billing_address'],
            'address_holder' => ['id_holder', 'address', 'commercial_address', 'removed_at'],
            'configuracion' => ['nombre_sistema', 'logo', 'favicon'],
        ] as $name => $fields) {
            Schema::create($name, function (Blueprint $table) use ($fields) {
                $table->id();
                foreach ($fields as $field) $table->text($field)->nullable();
            });
        }
        DB::table('configuracion')->insert(['nombre_sistema' => 'Romero IP', 'logo' => '', 'favicon' => '']);
        $user = \Mockery::mock(User::class)->makePartial();
        $user->forceFill(['id' => 1, 'name' => 'UI Review']);
        $user->shouldReceive('getRoleNames')->andReturn(collect(['Administrator']));
        $this->actingAs($user);
    }

    private function extendOwnersAndProfile(): void
    {
        Schema::table('holder', function (Blueprint $table) { $table->text('country')->nullable(); $table->text('notas')->nullable(); });
        Schema::create('users', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('email'); $table->timestamps(); });
        $migration = require database_path('migrations/2026_11_17_000001_extend_owners_and_profile.php');
        $migration->up();
        Schema::table('holder', fn (Blueprint $table) => $table->string('telephone_secondary', 60)->nullable());
    }

    public function test_owner_company_and_individual_share_name_and_preserve_addresses_and_trademarks(): void
    {
        $this->extendOwnersAndProfile();
        $this->post(route('store.holder'), ['owner_type' => 'Company', 'company_name' => 'Example Company', 'rfc' => 'ABC010203XX1',
            'country' => 'Mexico', 'telephone' => '+52 555 123', 'extension' => '103', 'mobile' => '+52 555 321', 'email' => 'owner@example.test',
            'address' => [str_repeat('Long address ', 1000)], 'commercial_address' => ['Industrial address']])->assertRedirect(route('index.holder'))->assertSessionHasNoErrors();
        $owner = \App\Models\Holder::first(); $address = \App\Models\AddressHolder::first();
        $this->assertSame('Industrial address', $address->commercial_address);
        $this->assertGreaterThan(10000, strlen($address->address));
        $record = new Trademarks(); $record->forceFill(['id_holder' => $owner->id, 'address_holder' => $address->id, 'trademark' => 'Linked Mark'])->save();
        $response = $this->patch(route('update.holder', $owner->id), ['owner_type' => 'Individual', 'company_name' => 'Example Full Name', 'country' => 'Italy',
            'curp' => 'CURP010203EXAMPLE', 'rfc' => 'RFC010203XX1', 'sex' => 'Female', 'date_of_birth' => '1980-05-06', 'place_of_birth' => 'Rome',
            'telephone' => '123', 'extension' => '4', 'mobile' => '567', 'email' => 'person@example.test',
            'address_ids' => [$address->id, null], 'address' => ['Changed address', 'Second address'], 'commercial_address' => ['Changed commercial address', 'Second commercial address']]);
        $response->assertRedirect(route('index.holder'))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('holder', ['id' => $owner->id, 'owner_type' => 'Individual', 'company_name' => 'Example Full Name', 'date_of_birth' => '1980-05-06', 'place_of_birth' => 'Rome', 'email' => 'person@example.test']);
        $this->assertDatabaseHas('address_holder', ['id' => $address->id, 'address' => 'Changed address', 'commercial_address' => 'Changed commercial address']);
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'id_holder' => $owner->id, 'address_holder' => $address->id]);
        $this->assertDatabaseCount('address_holder', 2);
        $this->patch(route('update.holder', $owner->id), ['owner_type' => 'Company', 'company_name' => 'Changed Company', 'country' => 'Italy'])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('holder', ['id' => $owner->id, 'curp' => 'CURP010203EXAMPLE', 'date_of_birth' => '1980-05-06']);
        $this->assertDatabaseCount('address_holder', 2);
        $this->get(route('edit.holder', $owner->id))->assertOk()->assertSee('Changed commercial address')->assertSee('Country')->assertSee('Contact Information');
        $this->patchJson(route('update.holder', $owner->id), ['owner_type' => 'Unknown', 'company_name' => 'Name', 'date_of_birth' => 'not-a-date', 'email' => 'not-email'])->assertUnprocessable()->assertJsonValidationErrors(['owner_type','date_of_birth','email']);
    }

    public function test_owner_forms_keep_country_catalog_and_reject_another_owners_address(): void
    {
        $this->extendOwnersAndProfile();
        $owner = \App\Models\Holder::create(['company_name' => 'Original owner', 'country' => 'MEXICO', 'notas' => 'Keep legacy notes']);
        $other = \App\Models\Holder::create(['company_name' => 'Other']);
        $address = \App\Models\AddressHolder::create(['id_holder' => $other->id, 'address' => 'Other address']);
        $this->patchJson(route('update.holder', $owner->id), ['company_name' => 'Attempted change', 'address_ids' => [$address->id], 'address' => ['Bad update']])->assertNotFound();
        $this->assertDatabaseHas('holder', ['id' => $owner->id, 'company_name' => 'Original owner', 'notas' => 'Keep legacy notes']);
        $this->assertDatabaseHas('address_holder', ['id' => $address->id, 'address' => 'Other address']);
        $response = $this->get(route('create.holder'))->assertOk();
        $doc = $this->document($response->getContent());
        $this->assertSame('Company', $doc->query('//input[@name="owner_type" and @checked]')->item(0)->getAttribute('value'));
        $this->assertSame(1, $doc->query('//input[@name="company_name"]')->length);
        $this->assertSame(250, $doc->query('//select[@id="country"]/option')->length);
        $this->assertSame(3, $doc->query('//section[contains(@class,"owner-section")]')->length);
        $this->assertSame(4, $doc->query('//*[contains(@class,"owner-contact-grid")]//input[not(@disabled)]')->length);
        $this->assertSame(0, $doc->query('//input[@name="first_name" or @name="last_name"]')->length);
        $this->get(route('edit.holder', $owner->id))->assertOk()->assertSee('value="MEXICO" data-country-code="MX" selected', false);
        $created = $this->get(route('create.trademarks'))->assertOk();
        $doc = $this->document($created->getContent());
        $this->assertSame(1, $doc->query('//aside//button[@form="trademarkForm" and normalize-space(.)="Save"]')->length);
    }

    public function test_profile_menu_uses_saved_name_position_email_and_shared_photo_crop(): void
    {
        $this->extendOwnersAndProfile();
        DB::table('users')->insert([['id' => 1, 'name' => 'UI Review', 'email' => 'one@example.test'], ['id' => 2, 'name' => 'Other user', 'email' => 'two@example.test']]);
        $user = $this->app['auth']->user(); $user->exists = true; $user->setTable('users');
        $this->patch(route('account.profile.update'), ['name' => 'Display Name Test', 'job_title' => 'Example Position', 'email' => 'updated@example.test', 'user_id' => 2])->assertRedirect(route('account.profile'))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['id' => 1, 'name' => 'Display Name Test', 'job_title' => 'Example Position', 'email' => 'updated@example.test']);
        $this->assertDatabaseHas('users', ['id' => 2, 'name' => 'Other user', 'email' => 'two@example.test', 'job_title' => null]);
        $user->forceFill(['profile_photo_path' => 'logo/romeroip-logo.jpeg', 'profile_photo_x' => 30, 'profile_photo_y' => 65, 'profile_photo_zoom' => 1.5]);
        $response = $this->get(route('index.trademarks'))->assertOk(); $doc = $this->document($response->getContent());
        $this->assertSame(0, $doc->query('//button[@id="legalProfileButton"]//*[contains(@class,"legal-chevron")]')->length);
        $this->assertSame(2, $doc->query('//div[contains(@class,"legal-profile")]//img[contains(@style,"object-position:30% 65%;transform:scale(1.5)")]')->length);
        $this->assertSame(1, $doc->query('//li[contains(@class,"legal-profile-summary")]//strong[normalize-space(.)="Display Name Test"]')->length);
        $response->assertSee('Example Position')->assertSee('updated@example.test')->assertSee('Custom Template');
        $this->assertSame(['My Profile','Account Settings','Sign Out'], $this->texts($doc->query('//ul[contains(@class,"legal-profile-menu")]//a | //ul[contains(@class,"legal-profile-menu")]//button')));
        $this->get(route('account.profile'))->assertOk()->assertSee('Job Title / Position')->assertSee('Display Name');
        $user->setAttribute('job_title', null);
        $html = $this->get(route('index.trademarks'))->assertOk()->getContent();
        $this->assertStringNotContainsString('Example Position', $html);
        $this->patchJson(route('account.profile.update'), ['name' => 'A', 'email' => 'bad-email', 'job_title' => str_repeat('x', 256)])->assertUnprocessable()->assertJsonValidationErrors(['email','job_title']);
    }

    public function test_new_optional_columns_preserve_existing_preferences_and_export_only_when_enabled(): void
    {
        $oldKeys = array_values(array_diff(array_keys(\App\Support\ResultsColumns::definitions()), ['application_date', 'int_registration_no']));
        $saved = ['order' => $oldKeys, 'visible' => ['select','edit','our_ref','trademark','owner'], 'widths' => ['trademark' => 319, 'owner' => 287]];
        $normalized = \App\Support\ResultsColumns::normalize($saved);
        $this->assertSame($oldKeys, array_values(array_diff($normalized['order'], ['application_date','int_registration_no'])));
        $this->assertSame($saved['visible'], $normalized['visible']);
        $this->assertSame(319, $normalized['widths']['trademark']);
        $this->assertNotContains('application_date', \App\Support\ResultsColumns::normalize(null)['visible']);
        $this->assertNotContains('int_registration_no', \App\Support\ResultsColumns::normalize(null)['visible']);
        $record = Trademarks::create(['our_ref' => '123', 'status' => 'Pending', 'filing_date_general' => '2023-07-12', 'int_registration_no' => '001234567']);
        $this->assertSame('Jul/12/2023', \App\Support\ResultsColumns::value($record, 'application_date'));
        $response = $this->get(route('advance_search'))->assertOk();
        $doc = $this->document($response->getContent());
        $this->assertSame(2, $doc->query('//thead//th[@hidden and (@data-column="application_date" or @data-column="int_registration_no")]')->length);
        $response->assertSee('Customize column visibility, order, and width.')->assertSee('data-columns-reset>Reset', false);
        foreach ([false, true] as $enabled) {
            $visible = $saved; if ($enabled) $visible['visible'] = array_merge($visible['visible'], ['application_date','int_registration_no']);
            $this->app['auth']->user()->setAttribute('results_columns', $visible);
            $export = $this->postJson(route('trademarks.export'), ['ids' => [$record->id], 'format' => 'csv'])->assertOk();
            $path = $export->baseResponse->getFile()->getPathname();
            try {
                $file = fopen($path, 'rb'); $headers = fgetcsv($file); $row = fgetcsv($file); fclose($file);
                $this->assertSame($enabled, in_array('Application Date', $headers, true));
                $this->assertSame($enabled, in_array("Int'l Registration No.", $headers, true));
                if ($enabled) { $this->assertContains('Jul/12/2023', $row); $this->assertContains('001234567', $row); }
            } finally { @unlink($path); }
        }
    }

    public function test_additional_address_removal_preserves_history_and_never_reuses_archived_rows(): void
    {
        $this->extendOwnersAndProfile();
        $owner = \App\Models\Holder::create(['company_name' => 'Legacy owner', 'extension' => '123', 'rfc' => 'TAX123']);
        $original = \App\Models\AddressHolder::create(['id_holder' => $owner->id, 'address' => 'Original address']);
        $additional = \App\Models\AddressHolder::create(['id_holder' => $owner->id, 'address' => 'Historical address', 'commercial_address' => 'Historical commercial']);
        $record = new Trademarks(); $record->forceFill(['trademark' => 'History', 'id_holder' => $owner->id, 'address_holder' => $additional->id])->save();
        $response = $this->patch(route('update.holder', $owner->id), ['owner_type' => 'Company', 'company_name' => 'Legacy owner',
            'telephone_secondary' => '555-222', 'removed_address_ids' => [$additional->id], 'address_ids' => [$original->id, null],
            'address' => ['Original address', 'Brand new address'], 'commercial_address' => [null,'Brand new commercial']])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('holder', ['id' => $owner->id, 'telephone_secondary' => '555-222', 'extension' => '123', 'rfc' => 'TAX123']);
        $this->assertNotNull($additional->fresh()->removed_at);
        $this->assertSame('Historical address', $additional->fresh()->address);
        $this->assertDatabaseCount('address_holder', 3);
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'address_holder' => $additional->id]);
        $this->get(route('show.trademarks', $record->id))->assertOk()->assertSee('Historical address');
        $edit = $this->get(route('edit.holder', $owner->id))->assertOk();
        $edit->assertDontSee('Historical address')->assertSee('Brand new address')->assertSee('Tax No.');
        $doc = $this->document($edit->getContent());
        $this->assertSame(1, $doc->query('//*[@data-owner-addresses]//button[@data-owner-remove-address]')->length);
        $this->assertSame(['Owner Information','Contact Information','Address Information'], $this->texts($doc->query('//section[contains(@class,"owner-section")]/h2')));
        $this->patchJson(route('update.holder', $owner->id), ['company_name' => 'Should roll back', 'removed_address_ids' => [$original->id]])->assertUnprocessable();
        $this->assertDatabaseHas('holder', ['id' => $owner->id, 'company_name' => 'Legacy owner']);
        $other = \App\Models\Holder::create(['company_name' => 'Other']);
        $foreign = \App\Models\AddressHolder::create(['id_holder' => $other->id, 'address' => 'Other owner']);
        $this->patchJson(route('update.holder', $owner->id), ['company_name' => 'Should roll back', 'removed_address_ids' => [$foreign->id]])->assertNotFound();
        $this->assertNull($foreign->fresh()->removed_at);
    }

    public function test_search_frosted_header_trial_is_scoped_and_can_be_disabled(): void
    {
        Trademarks::create(['trademark' => 'Scope Test']);
        foreach (['index.trademarks','advance_search'] as $route) {
            $doc = $this->document($this->get(route($route))->assertOk()->getContent());
            $this->assertSame(1, $doc->query('//nav[contains(@class,"legal-search-frosted")]')->length);
        }
        foreach (['create.trademarks','create.holder','account.profile'] as $route) {
            $doc = $this->document($this->get(route($route))->assertOk()->getContent());
            $this->assertSame(0, $doc->query('//nav[contains(@class,"legal-search-frosted")]')->length);
        }
        $this->get(route('show.trademarks', 1))->assertOk()->assertDontSee('legal-search-frosted');
        config(['kept.search_frosted_header' => false]);
        $this->get(route('index.trademarks'))->assertOk()->assertDontSee('legal-search-frosted');
    }

    public function test_search_queries_all_number_fields_and_combines_primary_and_advanced_filters(): void
    {
        $holder = DB::table('holder')->insertGetId(['company_name' => 'Example Owner']);
        $client = DB::table('clients')->insertGetId(['company_name' => 'Example Client']);
        $record = Trademarks::create([
            'trademark' => 'Searchable Mark', 'our_ref' => '77889', 'client_ref' => 'UniqueRef',
            'application_no' => '123456', 'registration_no' => '654321',
            'int_registration_no' => 'INT887', 'opposition_no' => 'OPP991', 'litigation_no' => 'LIT992',
            'id_holder' => $holder, 'id_client' => $client, 'country' => 'MEXICO',
            'origin' => 'International', 'class' => '07', 'status' => 'Registered',
            'filing_date_general' => '2025-06-15',
        ]);
        $record->forceFill(['id_holder' => $holder])->save();
        foreach (['77889', 'UniqueRef', 'Searchable', '123456', '654321', 'INT887', 'OPP991', 'LIT992', 'Example Owner', 'Example Client'] as $query) {
            $response = $this->get(route('advance_search', ['q' => $query, 'country' => 'Mexico',
                'origin' => 'International', 'class' => '07', 'status' => 'Registered',
                'filing_from' => '2025-01-01', 'filing_to' => '2025-12-31']))->assertOk();
            $this->assertSame([$record->id], $response->viewData('trademarks')->pluck('id')->all(), $query);
        }
        $response = $this->get(route('advance_search', ['q' => 'Example', 'class' => '08']))->assertOk();
        $this->assertSame(0, $response->viewData('trademarks')->total());
        $response = $this->get(route('advance_search', ['q' => 'Example']))->assertOk();
        $this->assertSame(1, $response->viewData('trademarks')->total());
    }

    public function test_catalogs_preserve_saved_values_and_use_distinct_country_and_office_lists(): void
    {
        $countries = \App\Support\CountryCatalog::entries();
        $offices = \App\Support\CountryCatalog::entries(true);
        $this->assertCount(249, $countries);
        $this->assertArrayNotHasKey('OA', $countries);
        $this->assertArrayHasKey('OA', $offices);
        $this->assertSame('Mexico', \App\Support\CountryCatalog::label('MX', true));
        $html = view('shared.country-options', ['currentCountry' => 'MEXICO', 'offices' => true])->render();
        $this->assertStringContainsString('value="MEXICO" data-country-code="MX" selected>Mexico', $html);
        $record = Trademarks::create(['trademark' => 'Catalog Test', 'country' => 'MEXICO', 'country_office' => 'OA']);
        $response = $this->get(route('show.trademarks', $record->id))->assertOk();
        $response->assertSee('African Intellectual Property Organization (OAPI)');
        $doc = $this->document($response->getContent());
        $this->assertSame(1, $doc->query('//*[@data-edit-current-section]')->length);
        $this->assertSame(0, $doc->query('//*[contains(@class,"legal-sidebar-profile")]')->length);
        $this->get(route('index.trademarks'))->assertOk()->assertDontSee('data-quick-search', false);
        $this->get(route('edit.trademarks', $record->id))->assertOk()->assertSee('data-global-search', false);
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'country' => 'MEXICO', 'country_office' => 'OA']);
    }

    public function test_profile_photo_upload_replace_remove_and_validation(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email'); $table->string('profile_photo_path')->nullable(); $table->timestamps();
        });
        DB::table('users')->insert(['id' => 1, 'name' => 'UI Review', 'email' => 'photo@example.test']);
        $user = $this->app['auth']->user();
        $user->exists = true; $user->setTable('users');
        $this->post(route('account.photo'), ['photo' => \Illuminate\Http\UploadedFile::fake()->create('bad.svg', 1, 'image/svg+xml')])->assertSessionHasErrors('photo');
        $paths = [];
        try {
            for ($i = 0; $i < 2; $i++) {
                $temp = tempnam(sys_get_temp_dir(), 'photo');
                file_put_contents($temp, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a7WQAAAAASUVORK5CYII='));
                $upload = new \Illuminate\Http\UploadedFile($temp, 'avatar.png', 'image/png', null, true);
                $this->post(route('account.photo'), ['photo' => $upload])->assertRedirect(route('account.profile'))->assertSessionHasNoErrors();
                $paths[] = $user->profile_photo_path;
                $this->assertFileExists(public_path($user->profile_photo_path));
            }
            $this->assertFileDoesNotExist(public_path($paths[0]));
            $this->get(route('account.profile'))->assertOk()->assertSee($paths[1]);
            $this->delete(route('account.photo.remove'))->assertRedirect(route('account.profile'));
            $this->assertNull($user->profile_photo_path);
            $this->assertFileDoesNotExist(public_path($paths[1]));
        } finally { foreach ($paths as $path) @unlink(public_path($path)); }
    }

    public function test_search_status_live_defaults_and_office_filter_targets_country(): void
    {
        foreach (['Pending', 'Registered', 'Abandoned', 'Lapsed', null] as $status) {
            Trademarks::create(['trademark' => 'Office Test', 'country' => 'OA', 'country_office' => 'Mexico', 'status' => $status]);
        }
        foreach ([[], ['status' => 'all_except_abandoned'], ['status' => '']] as $filters) {
            $response = $this->get(route('advance_search', $filters + ['country' => 'African Intellectual Property Organization (OAPI)']))->assertOk();
            $this->assertSame(['Pending', 'Registered'], $response->viewData('trademarks')->pluck('status')->all());
        }
        $response = $this->get(route('advance_search', ['country' => 'Mexico']))->assertOk();
        $this->assertSame(0, $response->viewData('trademarks')->total());
        $response = $this->get(route('advance_search', ['status' => 'Abandoned']))->assertOk();
        $this->assertSame(['Abandoned'], $response->viewData('trademarks')->pluck('status')->all());
        $doc = $this->document($this->get(route('index.trademarks'))->assertOk()->getContent());
        $this->assertSame(['All', 'National', 'International'], $this->texts($doc->query('//select[@id="origin"]/option')));
        $this->assertSame(['All', 'Live', 'Pending', 'Registered', 'Abandoned'], $this->texts($doc->query('//select[@id="status"]/option')));
        $this->assertSame('Live', $doc->query('//select[@id="status"]/option[@selected]')->item(0)->getAttribute('value'));
        $this->assertStringContainsString('African Intellectual Property Organization (OAPI)', $doc->query('//select[@id="country"]')->item(0)->textContent);
    }

    public function test_specific_files_are_exact_inclusive_and_combine_without_duplicates(): void
    {
        foreach (['1002', '1005', '1006', '1008', '1009', '11002', '1002x'] as $ref) {
            Trademarks::create(['our_ref' => $ref, 'trademark' => 'Specific Test', 'status' => 'Pending']);
        }
        $filters = ['specific_files' => '1002, 1005-1008, 1006, 8888'];
        $response = $this->get(route('advance_search', $filters))->assertOk();
        $this->assertSame(['1002', '1005', '1006', '1008'], $response->viewData('trademarks')->pluck('our_ref')->all());
        $response = $this->get(route('advance_search', $filters + ['from_refs' => '1005', 'to_refs' => '1006']))->assertOk();
        $this->assertSame(['1005', '1006'], $response->viewData('trademarks')->pluck('our_ref')->all());
        foreach (['1002,', '1005-1002', '100x', '1002,,1005', '1-2-3', '0', '-1', '99999999999'] as $invalid) {
            $this->getJson(route('advance_search', ['specific_files' => $invalid]))->assertUnprocessable()->assertJsonValidationErrors('specific_files');
        }
        $this->getJson(route('advance_search', ['from_refs' => '10', 'to_refs' => '9']))->assertUnprocessable()->assertJsonValidationErrors('to_refs');
    }

    public function test_due_date_ranges_are_inclusive_and_accept_either_bound(): void
    {
        foreach (['2026-01-01', '2026-06-15', '2026-12-31'] as $i => $date) {
            Trademarks::create(['trademark' => 'Due Test', 'our_ref' => (string) ($i + 1), 'status' => 'Registered',
                'filing_date_general' => $date, 'registration_date' => $date, 'next_declaration' => $date, 'next_renewal' => $date,
                'last_declaration' => '2020-01-01', 'last_renewal' => '2020-01-01']);
        }
        foreach ([['filing_from', 'filing_to'], ['registration_from', 'registration_to'], ['last_declaration', 'next_declaration'], ['last_renewal', 'next_renewal']] as [$from, $to]) {
            foreach ([[$from => '2026-06-15'], [$to => '2026-06-15'], [$from => '2026-06-15', $to => '2026-06-15']] as $filters) {
                $result = $this->get(route('advance_search', $filters))->assertOk()->viewData('trademarks');
                $this->assertSame(count($filters) === 2 ? 1 : 2, $result->total());
            }
            $this->getJson(route('advance_search', [$from => '2026-12-31', $to => '2026-01-01']))->assertUnprocessable()->assertJsonValidationErrors($to);
        }
        Trademarks::create(['status' => 'Abandoned']);
        Trademarks::create(['status' => 'Lapsed']);
        $result = $this->get(route('advance_search', ['status' => 'All']))->assertOk()->viewData('trademarks');
        $this->assertSame(4, $result->total());
    }

    public function test_owner_update_preserves_address_ids_used_by_trademarks(): void
    {
        Schema::table('holder', function (Blueprint $table) { $table->text('country')->nullable(); $table->text('notas')->nullable(); });
        $owner = DB::table('holder')->insertGetId(['company_name' => 'Original', 'country' => 'Mexico']);
        $address = DB::table('address_holder')->insertGetId(['id_holder' => $owner, 'address' => 'Original Address', 'commercial_address' => 'Business Address']);
        $record = new Trademarks();
        $record->forceFill(['trademark' => 'Linked Mark', 'address_holder' => $address])->save();
        $this->patch(route('update.holder', $owner), ['company_name' => 'Updated', 'country' => 'Mexico',
            'address' => ['New Address'], 'commercial_address' => ['New Business'], 'address_ids' => [$address]])
            ->assertRedirect(route('index.holder'))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('address_holder', ['id' => $address, 'address' => 'New Address', 'commercial_address' => 'New Business']);
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'address_holder' => $address]);
        $this->patch(route('update.holder', $owner), ['company_name' => 'Updated Again', 'country' => 'Mexico'])
            ->assertRedirect(route('index.holder'));
        $this->assertDatabaseCount('address_holder', 1);
    }

    public function test_general_search_does_not_ignore_zero(): void
    {
        $match = Trademarks::create(['trademark' => 'Matching', 'our_ref' => '100', 'status' => 'Registered']);
        Trademarks::create(['trademark' => 'Unrelated', 'our_ref' => '999', 'status' => 'Pending']);
        $response = $this->get(route('advance_search', ['q' => '0']))->assertOk();
        $this->assertSame([$match->id], $response->viewData('trademarks')->pluck('id')->all());
    }

    public function test_search_has_no_duplicate_controls_and_preserves_country_values(): void
    {
        Trademarks::create(['country' => 'Legacy Territory']);
        $response = $this->get(route('index.trademarks'))->assertOk();
        $doc = $this->document($response->getContent());
        foreach (['our_ref', 'client_ref', 'trademark', 'application_no', 'registration_no', 'int_registration_no', 'opposition_no', 'litigation_no', 'id_holder', 'id_client'] as $name) {
            $this->assertSame(0, $doc->query('//form[@id="trademark-search-form"]//*[@name="'.$name.'"]')->length);
        }
        $response->assertSee('Search by trademark, reference, number, owner or client...');
        $response->assertSee('Legacy Territory')->assertSee('Afghanistan');
        $this->assertSame(4, $doc->query('//*[contains(@class,"tm-primary-filters")]//select')->length);
        $this->assertSame(4, $doc->query('//*[@data-range-display]')->length);
        $this->assertSame(0, $doc->query('//form[@id="trademark-search-form"]//input[@name="q"] | //input[@name="from_refs"] | //input[@name="to_refs"]')->length);
    }

    public function test_create_and_update_return_to_the_saved_file(): void
    {
        $this->post(route('store.trademarks'), [
            'trademark' => 'Test Mark', 'our_ref' => '17035', 'class' => '12',
            'registration_date' => '2023-02-23', 'status' => 'registered',
        ])->assertRedirect(route('show.trademarks', 1))->assertSessionHas('trademark_saved', true);

        $this->assertDatabaseHas('trademark', ['id' => 1, 'registration_date' => '2023-02-23']);
        $this->patch(route('update.trademarks', 1), [
            'trademark' => 'Updated Mark', 'registration_date' => '2024-02-29',
        ])->assertRedirect(route('show.trademarks', 1))->assertSessionHas('trademark_saved', true);
        $this->assertDatabaseHas('trademark', ['id' => 1, 'trademark' => 'Updated Mark', 'registration_date' => '2024-02-29']);
    }

    public function test_invalid_update_date_does_not_erase_the_saved_date(): void
    {
        $record = Trademarks::create(['trademark' => 'Test Mark', 'registration_date' => '2023-02-23']);
        $this->from(route('edit.trademarks', $record->id))->patch(route('update.trademarks', $record->id), [
            'registration_date' => '2023-02-31',
        ])->assertSessionHasErrors('registration_date');
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'registration_date' => '2023-02-23']);
    }

    public function test_header_and_actions_are_consistent_in_edit_and_saved_views(): void
    {
        $record = Trademarks::create([
            'trademark' => 'AOSOWING and Design', 'registration_no' => '2546357',
            'application_no' => '2736246', 'class' => '12', 'status' => 'registered',
            'our_ref' => '17035', 'client_ref' => 'NBTMZC220499',
            'registration_date' => '2023-02-23',
        ]);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $response = $this->get(route($route, $record->id))->assertOk();
            $response->assertSee('Registration No. 2546357 – Class 12');
            $response->assertSee('O/Ref. 17035 – C/Ref. NBTMZC220499');
            $response->assertSee('Registered');
            $document = $this->document($response->getContent());
            $this->assertSame(0, $document->query('//header//button | //header//a')->length);
            $back = $document->query('//*[contains(@class,"tm-page-actions")]/a')->item(0);
            $this->assertSame(route('index.trademarks'), $back->getAttribute('href'));
        }
        $this->get(route('show.trademarks', $record->id))->assertSee('Feb/23/2023');
    }

    public function test_general_keeps_field_order_and_number_when_values_are_empty(): void
    {
        $record = Trademarks::create(['trademark' => 'Pending Mark', 'application_no' => '12345', 'class' => '01']);
        $edit = $this->document($this->get(route('edit.trademarks', $record->id))->assertOk()->getContent());
        $show = $this->document($this->get(route('show.trademarks', $record->id))->assertOk()->getContent());
        $editLabels = $this->texts($edit->query('//section[@id="general"]//*[contains(@class,"tm-label")]'));
        $showLabels = $this->texts($show->query('//section[h2[contains(.,"General")]]//*[contains(@class,"tm-label")]'));
        $this->assertCount(16, $showLabels);
        $this->assertSame($editLabels, $showLabels);
        $this->assertStringContainsString('02 |', $show->query('//section[h2[contains(.,"General")]]/h2')->item(0)->textContent);
        $this->get(route('show.trademarks', $record->id))->assertSee('Application No. 12345 – Class 01');
    }

    public function test_new_file_uses_placeholders_and_success_notice_has_no_ok_button(): void
    {
        // An existing record must not leak into the new file's header.
        Trademarks::create(['trademark' => 'Existing Mark', 'our_ref' => '17035']);
        $response = $this->get(route('create.trademarks'))->assertOk();
        $header = $this->document($response->getContent())->query('//header')->item(0)->textContent;
        $this->assertStringContainsString('Trademark', $header);
        $this->assertStringContainsString('Application No. – Class', $header);
        $this->assertStringContainsString('Owner', $header);
        $this->assertStringContainsString('Client', $header);
        $this->assertStringContainsString('O/Ref. – C/Ref.', $header);
        $this->assertStringNotContainsString('Existing Mark', $header);
        $this->withSession(['trademark_saved' => true])->get(route('show.trademarks', 1))
            ->assertOk()->assertSee('showConfirmButton: false', false)->assertSee('timer: 4500', false);
    }

    public function test_ungranted_file_uses_application_number_even_when_a_registration_number_exists(): void
    {
        $record = Trademarks::create([
            'trademark' => 'Pending Mark', 'status' => 'pending', 'application_no' => '12345',
            'registration_no' => '67890', 'class' => '12',
        ]);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $response = $this->get(route($route, $record->id))->assertOk();
            $header = $this->document($response->getContent())->query('//header')->item(0)->textContent;
            $this->assertStringContainsString('Application No. 12345 – Class 12', $header);
            $this->assertStringNotContainsString('Registration No. 67890', $header);
        }
    }

    public function test_edit_preserves_status_across_casing_and_languages(): void
    {
        foreach (['pending', 'PENDING', 'Pendiente', 'Registrado', 'custom status'] as $status) {
            $record = Trademarks::create(['trademark' => 'Status Test', 'status' => $status]);
            $document = $this->document($this->get(route('edit.trademarks', $record->id))->assertOk()->getContent());
            $selected = $document->query('//select[@id="status"]/option[@selected]');
            $this->assertSame(1, $selected->length);
            $this->assertSame($status, $selected->item(0)->getAttribute('value'));
            $this->assertSame(1, $document->query('//label[@for="country_office"][contains(.,"Priority Country / Office")]')->length);
        }
    }

    private function document(string $html): \DOMXPath
    {
        $document = new \DOMDocument();
        @$document->loadHTML('<?xml encoding="UTF-8">' . $html);
        return new \DOMXPath($document);
    }

    public function test_small_form_defaults_options_order_and_single_line_countries(): void
    {
        $document = $this->document($this->get(route('create.trademarks'))->assertOk()->getContent());
        $this->assertSame(['Select', 'Pending', 'Registered', 'Abandoned'], $this->texts($document->query('//select[@id="status"]/option')));
        $this->assertSame('', $document->query('//select[@id="status"]/option[@selected]')->item(0)->getAttribute('value'));
        $this->assertSame(['Select', 'National', 'International'], $this->texts($document->query('//select[@id="origin"]/option')));
        $this->assertSame(1, $document->query('//input[@id="designated_countries"]')->length);
        $labels = $this->texts($document->query('//section[@id="general"]//label'));
        $this->assertSame('Priority Application No.', $labels[8]);
        $this->assertSame('Priority Date', $labels[9]);
        $this->assertSame('Priority Country / Office', $labels[10]);
        $this->assertContains('Contracting Party', $labels);
        $this->assertSame(1, $document->query('//select[@id="country"]/option[contains(.,"Mexico")]')->length);
    }

    public function test_client_reference_punctuation_survives_create_and_update(): void
    {
        $reference = 'MX-1.2/23 (A) [B]';
        $this->post(route('store.trademarks'), ['trademark' => 'Punctuation Test', 'client_ref' => $reference])
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => 1, 'client_ref' => $reference]);
        $this->patch(route('update.trademarks', 1), ['client_ref' => '[MX]/(24)-1.2'])
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => 1, 'client_ref' => '[MX]/(24)-1.2']);
    }

    public function test_saved_file_formats_legacy_country_and_origin_for_display(): void
    {
        $record = Trademarks::create(['trademark' => 'Legacy Test', 'country' => 'MEXICO', 'origin' => 'Extranjero']);
        $this->get(route('show.trademarks', $record->id))->assertOk()->assertSee('Mexico')->assertSee('International');
        $document = $this->document($this->get(route('edit.trademarks', $record->id))->assertOk()->getContent());
        $this->assertSame('International', $document->query('//select[@id="origin"]/option[@selected]')->item(0)->getAttribute('value'));
    }

    public function test_references_and_general_have_independent_columns_and_department_in_header(): void
    {
        $record = Trademarks::create(['trademark' => 'Layout Test', 'our_ref' => '13788', 'client_ref' => '75.644', 'origin' => 'International']);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $response = $this->get(route($route, $record->id))->assertOk();
            $document = $this->document($response->getContent());
            $this->assertStringContainsString('O/Ref. 13788 – C/Ref. 75.644 | International', $document->query('//header')->item(0)->textContent);
            $this->assertSame([2, 1], array_map(fn ($column) => $document->query('.//*[contains(@class,"tm-label")]', $column)->length,
                iterator_to_array($document->query('//section[@id="references"]//*[contains(@class,"tm-field-column")]'))));
            $this->assertSame([8, 8], array_map(fn ($column) => $document->query('.//*[contains(@class,"tm-label")]', $column)->length,
                iterator_to_array($document->query('//section[@id="general"]//*[contains(@class,"tm-field-column")]'))));
            $this->assertSame(1, $document->query('//section[@id="references"]//*[contains(@class,"tm-label") and contains(.,"Department")]')->length);
            $this->assertSame(1, $document->query('//section[@id="general"]//*[contains(@class,"tm-label") and normalize-space(.)="Country / Office"]')->length);
        }
    }

    public function test_maintenance_and_international_renewal_dates_are_saved_manually(): void
    {
        $dates = ['int_renewal_date' => '2032-08-22', 'last_declaration' => '2026-09-08',
            'last_renewal' => '2022-08-22', 'next_declaration' => '2032-08-17', 'next_renewal' => '2033-08-17'];
        $this->post(route('store.trademarks'), array_merge(['trademark' => 'Manual Dates'], $dates))
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $dates));
        $this->patch(route('update.trademarks', 1), ['registration_date' => '2025-01-01'])
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $dates));
        $this->patch(route('update.trademarks', 1), ['int_renewal_date' => '2032-02-31'])
            ->assertSessionHasErrors('int_renewal_date');
        $this->assertDatabaseHas('trademark', ['id' => 1, 'int_renewal_date' => '2032-08-22']);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $document = $this->document($this->get(route($route, 1))->assertOk()->getContent());
            $this->assertSame(['registration_date', 'first_date', 'country', 'country_office', 'int_registration_date', 'designated_countries'],
                array_map(fn ($row) => $row->getAttribute('data-spacer-after'), iterator_to_array($document->query('//section[@id="general"]/*//div[@data-spacer-after]'))));
            $this->assertSame(['Registration No.', 'Expiration Date'], $this->texts($document->query('//section[@id="general"]//*[contains(@class,"tm-field-emphasis")]/*[contains(@class,"tm-label")]')));
            $this->assertSame(['Last Declaration of Use', 'Last Renewal', 'Next Declaration of Use', 'Next Renewal'],
                $this->texts($document->query('//section[@id="maintenance"]//*[contains(@class,"tm-label")]')));
            foreach (array_keys($dates) as $field) {
                $this->assertSame(1, $document->query('//*[@data-field="' . $field . '"]')->length);
            }
        }
        $this->get(route('show.trademarks', 1))->assertSee('Aug/22/2032')->assertSee('Sep/08/2026');
        $this->patch(route('update.trademarks', 1), ['int_renewal_date' => ''])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => 1, 'int_renewal_date' => null]);
    }

    public function test_designated_countries_can_be_cleared_on_an_existing_file(): void
    {
        $record = Trademarks::create(['trademark' => 'Existing Mark', 'designated_countries' => 'MX']);
        $this->patch(route('update.trademarks', $record->id), ['designated_countries' => ''])
            ->assertRedirect(route('show.trademarks', $record->id))->assertSessionHasNoErrors()
            ->assertSessionMissing('swal_error')->assertSessionHas('trademark_saved', true);
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'designated_countries' => null, 'trademark' => 'Existing Mark']);
        $this->patch(route('update.trademarks', $record->id), ['designated_countries' => 'US, MX'])
            ->assertSessionHasNoErrors()->assertSessionMissing('swal_error');
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'designated_countries' => 'US, MX']);
    }

    public function test_trademark_text_preserves_unicode_punctuation_and_line_breaks(): void
    {
        $text = "Diseño ™ © — 日本語 / (A) [B]\n" . rtrim(str_repeat('Texto largo & símbolos. ', 30));
        $data = array_fill_keys(['translation', 'transliteration_trademark', 'disclaimer', 'description_trademark'], $text);
        $data['trademark'] = 'Vencedor y Diseño ™ 日本語';
        $this->post(route('store.trademarks'), $data)->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $data));
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $document = $this->document($this->get(route($route, 1))->assertOk()->getContent());
            $this->assertSame(['Trademark', 'Type of Appl.', 'Type of Mark', 'Translation', 'Transliteration', 'Disclaimer', 'Description'],
                $this->texts($document->query('//section[@id="trademark-section"]//*[contains(@class,"tm-label")]')));
        }
        $this->patch(route('update.trademarks', 1), ['translation' => "Updated ©\n第二行"])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => 1, 'translation' => "Updated ©\n第二行"]);
    }

    public function test_empty_mark_keeps_desktop_middle_cells_and_hides_empty_footer(): void
    {
        $record = Trademarks::create(['trademark' => 'Empty Mark']);
        $document = $this->document($this->get(route('show.trademarks', $record->id))->assertOk()->getContent());
        $this->assertSame(3, $document->query('//section[@id="trademark-section"]//*[contains(@class,"tm-mobile-empty") and not(contains(@class,"tm-spacer-row"))]')->length);
        $this->assertSame(0, $document->query('//section[@id="trademark-section"]//*[contains(@class,"tm-label") and (text()="Disclaimer" or text()="Description")]')->length);
    }

    public function test_logo_is_saved_and_retained_when_updating_other_fields(): void
    {
        $image = \Illuminate\Http\UploadedFile::fake()->createWithContent('sample.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a3XcAAAAASUVORK5CYII='));
        $path = null;
        try {
            $this->post(route('store.trademarks'), ['trademark' => 'Logo Test', 'design' => $image])
                ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
            $name = Trademarks::findOrFail(1)->design;
            $this->assertNotEmpty($name);
            $path = public_path('design/' . $name);
            $this->assertFileExists($path);
            $this->patch(route('update.trademarks', 1), ['translation' => 'Changed text'])->assertSessionMissing('swal_error');
            $this->assertDatabaseHas('trademark', ['id' => 1, 'design' => $name]);
            foreach (['edit.trademarks', 'show.trademarks'] as $route) {
                $this->get(route($route, 1))->assertOk()->assertSee(asset('design/' . $name));
            }
        } finally {
            if ($path && is_file($path)) unlink($path);
        }
    }

    public function test_logo_removal_is_explicit_and_does_not_affect_other_file_data(): void
    {
        $record = Trademarks::create(['trademark' => 'Keep Name', 'design' => 'existing.png']);
        $this->patch(route('update.trademarks', $record->id), ['translation' => 'Changed'])
            ->assertRedirect(route('show.trademarks', $record->id));
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'design' => 'existing.png']);
        $this->patch(route('update.trademarks', $record->id), ['remove_design' => '1'])
            ->assertRedirect(route('show.trademarks', $record->id))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => $record->id, 'design' => null, 'trademark' => 'Keep Name', 'translation' => 'Changed']);
        $this->get(route('edit.trademarks', $record->id))->assertSee('Drag and drop an image here');
    }

    public function test_goods_and_notes_use_shared_fields_and_preserve_saved_content(): void
    {
        $data = ['trademark' => 'Sections Test', 'class' => '07', 'description_good' => "Goods ™\n第二行",
            'translation_good' => "Translation\nLine two", 'notes' => "Notes ©\nLine two"];
        $this->post(route('store.trademarks'), $data)->assertRedirect(route('show.trademarks', 1));
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $data));
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $document = $this->document($this->get(route($route, 1))->assertOk()->getContent());
            $this->assertSame(['Class', 'Description', 'Translation'], $this->texts($document->query('//section[@id="accounts"]//*[contains(@class,"tm-label")]')));
            $this->assertSame(['Notes'], $this->texts($document->query('//section[@id="notes"]//*[contains(@class,"tm-label")]')));
        }
    }

    public function test_large_goods_translation_and_notes_can_be_created_and_updated(): void
    {
        $text = str_repeat("Installation, maintenance & reparación de grúas.\n", 150);
        $data = array_fill_keys(['notes', 'description_good', 'translation_good', 'description_trademark', 'translation', 'transliteration_trademark', 'disclaimer'], trim($text));
        $this->post(route('store.trademarks'), array_merge(['trademark' => 'Long Text'], $data))
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors()->assertSessionMissing('swal_error');
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $data));
        $this->patch(route('update.trademarks', 1), ['notes' => trim($text . $text)])
            ->assertSessionHasNoErrors()->assertSessionMissing('swal_error');
        $this->assertDatabaseHas('trademark', ['id' => 1, 'notes' => trim($text . $text)]);
    }

    public function test_deadlines_save_manually_and_empty_dates_display_a_dash(): void
    {
        $fields = ['opposition_deadline', 'opposition_response_date', 'closing_arguments_deadline', 'closing_arguments_date',
            'first_office_action_deadline', 'second_office_action_deadline', 'office_action_response',
            'additional_office_action_date', 'suspension_request_date', 'suspension_period_end_date'];
        $dates = array_fill_keys($fields, '2027-03-16');
        $this->post(route('store.trademarks'), array_merge(['trademark' => 'Deadline Test'], $dates))
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', array_merge(['id' => 1], $dates));
        $this->patch(route('update.trademarks', 1), ['opposition_deadline' => '2027-02-31'])->assertSessionHasErrors('opposition_deadline');
        $this->assertDatabaseHas('trademark', ['id' => 1, 'opposition_deadline' => '2027-03-16']);
        $this->patch(route('update.trademarks', 1), ['opposition_deadline' => ''])->assertSessionHasNoErrors();
        $document = $this->document($this->get(route('show.trademarks', 1))->assertOk()->getContent());
        $this->assertSame('—', trim($document->query('//*[@data-field="opposition_deadline"]/*[contains(@class,"tm-value")]')->item(0)->textContent));
        $this->assertSame(12, $document->query('//section[@id="dates-deadlines"]//*[@data-field]')->length);
        foreach (['owner', 'client'] as $id) {
            $this->assertSame(2, $document->query('//section[@id="' . $id . '"]//div[contains(@class,"tm-contact-pair")][1]/div')->length);
            $this->assertSame(array_fill(0, $id === 'owner' ? 2 : 3, '—'), $this->texts($document->query('//section[@id="' . $id . '"]//div[contains(@class,"tm-contact-pair")][1]//p')));
        }
    }

    public function test_contact_layout_removes_billing_fields_and_edit_uses_four_lines(): void
    {
        $record = Trademarks::create(['trademark' => 'Layout Test']);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $document = $this->document($this->get(route($route, $record->id))->assertOk()->getContent());
            $this->assertSame(0, $document->query('//section[@id="sessions" or @id="client"]//*[contains(@class,"tm-label") and (contains(.,"Invoice Recipient") or contains(.,"Billing Address"))]')->length);
            $this->assertSame(1, $document->query('//section[@id="holder" or @id="owner"]//*[contains(@class,"tm-label") and contains(.,"Estab.")]')->length);
            $this->assertSame(2, $document->query('//*[contains(@class,"tm-client-details")]/*[contains(@class,"tm-field")]')->length);
        }
        $document = $this->document($this->get(route('edit.trademarks', $record->id))->assertOk()->getContent());
        foreach (['disclaimer', 'description_trademark', 'description_good', 'translation_good', 'notes_text'] as $id) {
            $this->assertSame('4', $document->query('//textarea[@id="' . $id . '"]')->item(0)->getAttribute('rows'));
        }
        $document = $this->document($this->get(route('create.trademarks'))->assertOk()->getContent());
        $this->assertSame('2', $document->query('//textarea[@id="notes_text"]')->item(0)->getAttribute('rows'));
    }

    public function test_quick_search_is_exact_combines_three_fields_and_deduplicates_records(): void
    {
        $first = Trademarks::create(['trademark' => 'First', 'our_ref' => '13735', 'application_no' => '13735']);
        $second = Trademarks::create(['trademark' => 'Second', 'registration_no' => '13735']);
        Trademarks::create(['trademark' => 'Partial', 'application_no' => '137350']);
        $this->getJson(route('trademarks.quick-search', ['number' => '13735']))->assertOk()
            ->assertJsonCount(2, 'matches')->assertJsonPath('matches.0.id', $first->id)
            ->assertJsonPath('matches.0.matched_fields', ['Our Reference', 'Application No.'])
            ->assertJsonPath('matches.1.id', $second->id);
        foreach (['1373', '0013735', '999999'] as $number) {
            $this->getJson(route('trademarks.quick-search', ['number' => $number]))->assertOk()->assertJsonCount(0, 'matches');
        }
        $this->getJson(route('trademarks.quick-search', ['number' => '137350']))->assertOk()->assertJsonCount(1, 'matches');
        $this->getJson(route('trademarks.quick-search', ['number' => '13735x']))->assertUnprocessable()->assertJsonValidationErrors('number');
    }

    public function test_long_references_three_d_mark_and_sections_navigation(): void
    {
        $reference = str_repeat('CLIENT-123/ABC. ', 100) . '[END]';
        Trademarks::create(['trademark' => 'Navigation Test', 'our_ref' => '13545', 'client_ref' => $reference, 'type_mark' => 'Three-Dimensional Mark']);
        $this->patch(route('update.trademarks', 1), ['client_ref' => $reference])
            ->assertRedirect(route('show.trademarks', 1))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['id' => 1, 'client_ref' => $reference]);
        foreach (['edit.trademarks', 'show.trademarks'] as $route) {
            $response = $this->get(route($route, 1))->assertOk()->assertSee('3D Mark')->assertSee('File 13545');
            $document = $this->document($response->getContent());
            $this->assertSame(9, $document->query('//*[@data-section-link]')->length);
            foreach ($document->query('//*[@data-section-link]') as $link) {
                $this->assertSame(1, $document->query('//*[@id="' . $link->getAttribute('data-section-link') . '"]')->length);
            }
            $this->assertSame($route === 'edit.trademarks' ? 1 : 0, $document->query('//button[@form="trademarkEditForm"]')->length);
            $this->assertSame([6, 6], array_map(fn ($column) => $document->query('.//*[@data-field]', $column)->length,
                iterator_to_array($document->query('//section[@id="dates-deadlines"]/*[contains(@class,"tm-deadline-tables")]/div'))));
        }
        $document = $this->document($this->get(route('edit.trademarks', 1))->getContent());
        $this->assertFalse($document->query('//input[@id="client_ref"]')->item(0)->hasAttribute('maxlength'));
        $document = $this->document($this->get(route('show.trademarks', 1))->getContent());
        $this->assertSame($reference, $document->query('//*[@data-field="client_ref"]/p')->item(0)->getAttribute('title'));
    }

    public function test_account_settings_only_update_the_authenticated_users_allowed_fields(): void
    {
        Schema::create('users', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('email'); $table->string('preferred_locale')->nullable(); $table->timestamps(); });
        DB::table('users')->insert([['id' => 1, 'name' => 'UI Review', 'email' => 'first@example.test'], ['id' => 2, 'name' => 'Other User', 'email' => 'second@example.test']]);
        $this->app['auth']->user()->exists = true;
        $this->app['auth']->user()->setTable('users');
        $this->app['auth']->user()->forceFill(['email' => 'first@example.test']);
        $this->patch(route('account.update'), ['id' => 2, 'name' => 'Updated Name', 'email' => 'updated@example.test', 'locale' => 'en', 'roles' => ['Administrator']])
            ->assertRedirect(route('account.settings'))->assertSessionHas('account_saved', true);
        $this->assertDatabaseHas('users', ['id' => 1, 'name' => 'Updated Name', 'email' => 'updated@example.test']);
        $this->assertDatabaseHas('users', ['id' => 2, 'name' => 'Other User', 'email' => 'second@example.test']);
        $this->get(route('account.profile'))->assertOk()->assertSee('Updated Name');
    }

    public function test_client_reference_accepts_thirty_characters_and_explains_new_errors(): void
    {
        $reference = str_repeat('A', 30);
        $this->post(route('store.trademarks'), ['trademark' => 'Reference Test', 'client_ref' => $reference])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trademark', ['client_ref' => $reference]);
        $this->patch(route('update.trademarks', 1), ['client_ref' => str_repeat('B', 31)])->assertSessionHasErrors('client_ref');
        $this->assertDatabaseHas('trademark', ['id' => 1, 'client_ref' => $reference]);
        $this->patch(route('update.trademarks', 1), ['client_ref' => 'Unsupported@'])->assertSessionHasErrors('client_ref');
    }

    public function test_global_search_matches_names_references_and_exact_numbers(): void
    {
        $owner = DB::table('holder')->insertGetId(['company_name' => 'Global Owner']);
        $client = DB::table('clients')->insertGetId(['company_name' => 'Global Client']);
        $record = new Trademarks();
        $record->forceFill(['trademark' => 'Global Mark', 'id_holder' => $owner, 'id_client' => $client,
            'our_ref' => '13811', 'application_no' => '13811', 'registration_no' => '999', 'client_ref' => 'ABC-Ref'])->save();
        foreach (['Global Mark', 'Global Owner', 'Global Client', 'ABC-Ref', '13811', '999'] as $term) {
            $this->getJson(route('trademarks.global-search', ['q' => $term]))->assertOk()->assertJsonCount(1, 'matches')->assertJsonPath('matches.0.id', $record->id);
        }
        $this->getJson(route('trademarks.global-search', ['q' => '1381']))->assertOk()->assertJsonCount(0, 'matches');
        $this->getJson(route('trademarks.global-search', ['q' => 'No Such Mark']))->assertOk()->assertJsonCount(0, 'matches');
        $this->getJson(route('trademarks.global-search', ['q' => '']))->assertUnprocessable();
        $response = $this->get(route('index.trademarks'))->assertOk();
        $doc = $this->document($response->getContent());
        $this->assertSame(1, $doc->query('//*[@data-global-search]')->length);
        $this->assertSame(5, $doc->query('//*[contains(@class,"legal-new")]//li/a')->length);
        $this->assertSame(0, $doc->query('//form[@id="trademark-search-form"]//button[@type="submit"]')->length);
    }

    public function test_live_results_paginate_on_the_server_with_synchronized_controls(): void
    {
        $rows = [];
        for ($i = 1; $i <= 125; $i++) {
            $rows[] = ['our_ref' => (string) (10000 + $i), 'trademark' => 'Page Test', 'status' => $i % 2 ? 'Pending' : 'Registered'];
        }
        $rows[] = ['our_ref' => '99999', 'trademark' => 'Abandoned record', 'status' => 'Abandoned'];
        DB::table('trademark')->insert($rows);
        $response = $this->get(route('advance_search', ['status' => 'Live']))->assertOk();
        $page = $response->viewData('trademarks');
        $this->assertSame(125, $page->total());
        $this->assertSame(50, $page->count());
        $this->assertSame(50, $page->perPage());
        $doc = $this->document($response->getContent());
        $this->assertSame(2, $doc->query('//*[@data-results-pagination]')->length);
        $this->assertSame(2, $doc->query('//*[@data-results-page-size]/option[@selected and @value="50"]')->length);
        $this->assertSame(22, $doc->query('//table[@id="products-list"]/thead/tr/th')->length);
        $this->assertSame('Results', trim($doc->query('//*[contains(@class,"tm-results-panel")]//h5')->item(0)->textContent));
        $this->assertSame(2, $doc->query('//*[@data-results-page and normalize-space(.)="Last"]')->length);
        $response = $this->get(route('advance_search', ['status' => 'Live', 'page' => 3]))->assertOk();
        $lastPage = $response->viewData('trademarks');
        $this->assertSame(25, $lastPage->count());
        $this->assertSame(3, $lastPage->currentPage());
        $this->assertSame(125, $lastPage->total());
        $doc = $this->document($response->getContent());
        $this->assertSame(2, $doc->query('//*[@data-results-page and normalize-space(.)="First"]')->length);
        $clamped = $this->get(route('advance_search', ['status' => 'Live', 'page' => 99]))->assertOk()->viewData('trademarks');
        $this->assertSame(3, $clamped->currentPage());
        $response = $this->get(route('advance_search', ['q' => 'NotFound']))->assertOk();
        $response->assertSee('No results to display.')->assertSee('Use global search or advanced filters to find specific trademark records.');
        $this->assertSame(0, $this->document($response->getContent())->query('//*[@data-results-pagination]')->length);
    }

    public function test_result_sorting_is_typed_and_applies_before_pagination(): void
    {
        foreach (['100', '9', '20'] as $i => $ref) {
            $holder = DB::table('holder')->insertGetId(['company_name' => ['Zulu', 'Alpha', 'Middle'][$i]]);
            $client = DB::table('clients')->insertGetId(['company_name' => ['Alpha', 'Zulu', 'Middle'][$i]]);
            $record = new Trademarks();
            $record->forceFill(['our_ref' => $ref, 'id_holder' => $holder, 'id_client' => $client,
                'trademark' => ['C', 'A', 'B'][$i], 'application_no' => $ref, 'registration_no' => $ref,
                'registration_date' => ['2023-01-01', '2021-01-01', '2022-01-01'][$i], 'status' => 'Registered'])->save();
        }
        foreach (['our_ref', 'application_no', 'registration_no', 'registration_date', 'trademark', 'owner'] as $sort) {
            $page = $this->get(route('advance_search', ['sort' => $sort]))->assertOk()->viewData('trademarks');
            $this->assertSame(['9', '20', '100'], $page->pluck('our_ref')->all(), $sort);
            $page = $this->get(route('advance_search', ['sort' => $sort, 'direction' => 'desc']))->assertOk()->viewData('trademarks');
            $this->assertSame(['100', '20', '9'], $page->pluck('our_ref')->all(), $sort);
        }
        $page = $this->get(route('advance_search', ['sort' => 'client']))->assertOk()->viewData('trademarks');
        $this->assertSame(['100', '20', '9'], $page->pluck('our_ref')->all());
        for ($i = 30; $i < 60; $i++) Trademarks::create(['our_ref' => (string) $i, 'status' => 'Registered']);
        $page = $this->get(route('advance_search', ['per_page' => 25, 'page' => 2]))->assertOk()->viewData('trademarks');
        $this->assertSame(['53', '54', '55', '56', '57', '58', '59', '100'], $page->pluck('our_ref')->all());
        $this->getJson(route('advance_search', ['sort' => 'id; DROP TABLE trademark']))->assertUnprocessable()->assertJsonValidationErrors('sort');
        $this->getJson(route('advance_search', ['direction' => 'invalid']))->assertUnprocessable()->assertJsonValidationErrors('direction');
    }

    public function test_results_use_next_dates_and_include_saved_addresses_and_country(): void
    {
        $owner = DB::table('holder')->insertGetId(['company_name' => 'Owner Test']);
        $client = DB::table('clients')->insertGetId(['company_name' => 'Client Test']);
        $oa = DB::table('address_holder')->insertGetId(['id_holder' => $owner, 'address' => 'Owner Street 10']);
        $ca = DB::table('adress_clients')->insertGetId(['id_clients' => $client, 'address' => 'Client Street 20']);
        $record = new Trademarks(); $record->forceFill(['trademark' => 'Dates and Addresses', 'status' => 'Registered', 'our_ref' => '123',
            'id_holder' => $owner, 'id_client' => $client, 'address_holder' => $oa, 'id_address' => $ca, 'country' => 'MX',
            'next_renewal' => '2034-07-12', 'last_renewal' => '2024-07-12', 'next_declaration' => '2030-07-12', 'last_declaration' => '2027-07-12'])->save();
        $response = $this->get(route('advance_search'))->assertOk();
        $doc = $this->document($response->getContent());
        foreach (['last_renewal' => 'Jul/12/2034', 'previous_renewal' => 'Jul/12/2024', 'last_declaration' => 'Jul/12/2030',
            'previous_declaration' => 'Jul/12/2027', 'owner_address' => 'Owner Street 10', 'client_address' => 'Client Street 20', 'country' => 'Mexico'] as $key => $value) {
            $this->assertSame($value, trim($doc->query('//tbody/tr/td[@data-column="'.$key.'"]')->item(0)->textContent));
        }
        $this->get(route('show.trademarks', $record->id))->assertOk()->assertSee('Search by file, application or registration number...');
        $this->get(route('create.trademarks'))->assertOk()->assertSee('data-search-mode="file"', false);
        $this->get(route('index.trademarks'))->assertOk()->assertSee('Search by trademark, reference, number, owner or client...')->assertDontSee('aria-label="Language"', false);
        $this->assertSame(0, $doc->query('//*[@aria-label="Previous page" or @aria-label="Next page"]')->length);
        $this->assertSame(0, $doc->query('//*[@data-results-page and (normalize-space(.)="First" or normalize-space(.)="Last")]')->length);
        $old = ['order' => ['select','edit','our_ref','trademark','last_renewal','owner','client','origin'], 'visible' => ['our_ref','trademark','owner']];
        $preferences = \App\Support\ResultsColumns::normalize($old);
        $this->assertSame(array_search('last_renewal', $preferences['order']) + 1, array_search('previous_declaration', $preferences['order']));
        $this->assertSame(array_search('owner', $preferences['order']) + 1, array_search('owner_address', $preferences['order']));
        $this->assertNotContains('owner_address', $preferences['visible']);
    }

    public function test_profile_photo_position_is_saved_only_for_current_user(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email'); $table->string('profile_photo_path')->nullable(); $table->string('preferred_locale')->nullable(); $table->timestamps();
        });
        $migration = require database_path('migrations/2026_11_13_000001_add_profile_photo_position.php'); $migration->up();
        DB::table('users')->insert([['id' => 1, 'name' => 'UI Review', 'email' => 'one@example.test'], ['id' => 2, 'name' => 'Other', 'email' => 'two@example.test']]);
        $user = $this->app['auth']->user(); $user->exists = true; $user->setTable('users');
        $data = ['name' => 'UI Review', 'email' => 'one@example.test', 'locale' => 'en', 'profile_photo_x' => 25, 'profile_photo_y' => 70, 'profile_photo_zoom' => 1.5, 'user_id' => 2];
        $this->patchJson(route('account.update'), $data)->assertRedirect(route('account.settings'));
        $this->assertDatabaseHas('users', ['id' => 1, 'profile_photo_x' => 25, 'profile_photo_y' => 70, 'profile_photo_zoom' => 1.5]);
        $this->assertDatabaseHas('users', ['id' => 2, 'profile_photo_x' => 50, 'profile_photo_y' => 50, 'profile_photo_zoom' => 1]);
        $this->patchJson(route('account.update'), array_replace($data, ['profile_photo_x' => 101, 'profile_photo_zoom' => 4]))->assertUnprocessable()->assertJsonValidationErrors(['profile_photo_x', 'profile_photo_zoom']);
    }

    public function test_all_export_formats_use_real_complete_records_and_applied_sort(): void
    {
        $one = Trademarks::create(['our_ref' => '2', 'trademark' => 'Diseño & Associates '.str_repeat('complete ', 35), 'status' => 'Registered', 'client_ref' => '=1+1', 'next_renewal' => '2034-07-12']);
        $two = Trademarks::create(['our_ref' => '10', 'trademark' => 'Second Record', 'status' => 'Pending']);
        $abandoned = Trademarks::create(['our_ref' => '3', 'trademark' => 'Excluded', 'status' => 'Abandoned']);
        foreach (['xlsx', 'csv', 'docx', 'pdf', 'template'] as $format) {
            $response = $this->postJson(route('trademarks.export'), ['ids' => [$one->id, $two->id, $abandoned->id], 'format' => $format,
                'template' => 'kept-standard', 'sort' => 'our_ref', 'direction' => 'desc'])->assertOk();
            $path = $response->baseResponse->getFile()->getPathname();
            try {
                if (in_array($format, ['xlsx', 'template'])) {
                    $book = \PhpOffice\PhpSpreadsheet\IOFactory::load($path); $sheet = $book->getActiveSheet();
                    $this->assertSame('10', $sheet->getCell('A2')->getValue());
                    $this->assertSame('2', $sheet->getCell('A3')->getValue());
                    $this->assertSame(3, $sheet->getHighestRow());
                    $this->assertSame($one->trademark, $sheet->getCell('B3')->getValue());
                    $this->assertSame('s', $sheet->getCell('O3')->getDataType());
                    $this->assertSame('=1+1', $sheet->getCell('O3')->getValue());
                    $this->assertSame('Helvetica Neue', $sheet->getCell('B3')->getStyle()->getFont()->getName());
                    $this->assertSame(10.0, $sheet->getCell('B3')->getStyle()->getFont()->getSize());
                    $this->assertSame(120, $sheet->getSheetView()->getZoomScale());
                    $this->assertSame('A2', $sheet->getFreezePane());
                    $this->assertSame('FFD9D9D9', $sheet->getStyle('A1')->getFill()->getStartColor()->getARGB());
                    $this->assertSame('thin', $sheet->getStyle('A2')->getBorders()->getLeft()->getBorderStyle());
                    $this->assertSame('center', $sheet->getStyle('A2')->getAlignment()->getHorizontal());
                    $this->assertStringContainsString('mmm/dd/yyyy', $sheet->getStyle('H3')->getNumberFormat()->getFormatCode());
                    $this->assertGreaterThan(21, $sheet->getRowDimension(3)->getRowHeight());
                    $book->disconnectWorksheets();
                } elseif ($format === 'csv') {
                    $file = fopen($path, 'rb'); $headers = fgetcsv($file); $first = fgetcsv($file); $second = fgetcsv($file); fclose($file);
                    $this->assertSame('10', $first[0]); $this->assertSame('2', $second[0]);
                    $this->assertSame($one->trademark, $second[1]);
                    $this->assertContains("'=1+1", $second);
                } elseif ($format === 'docx') {
                    $zip = new \ZipArchive(); $zip->open($path); $xml = $zip->getFromName('word/document.xml'); $zip->close();
                    $this->assertStringContainsString('Diseño &amp; Associates', $xml);
                    $this->assertStringNotContainsString('Excluded', $xml);
                } else {
                    $this->assertStringStartsWith('%PDF-', file_get_contents($path));
                    $this->assertGreaterThan(5000, filesize($path));
                }
            } finally { @unlink($path); }
        }
        $this->postJson(route('trademarks.export'), ['ids' => [$one->id], 'format' => 'template', 'template' => '../../secrets'])->assertUnprocessable();
        $this->postJson(route('trademarks.export'), ['ids' => [], 'format' => 'xlsx'])->assertUnprocessable();
    }

    public function test_results_preferences_are_private_persistent_and_keep_frozen_columns(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email'); $table->timestamps();
        });
        $migration = require database_path('migrations/2026_11_11_000001_add_results_preferences_to_users.php');
        $migration->up();
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'UI Review', 'email' => 'one@example.test'],
            ['id' => 2, 'name' => 'Other User', 'email' => 'two@example.test'],
        ]);
        $user = $this->app['auth']->user(); $user->exists = true; $user->setTable('users');
        $preferences = ['order' => ['status', 'client', 'our_ref'], 'visible' => ['status'], 'widths' => ['trademark' => 310]];
        $response = $this->patchJson(route('account.results'), $preferences)->assertOk();
        $this->assertSame(['select', 'edit', 'our_ref', 'trademark'], array_slice($response->json('order'), 0, 4));
        $this->assertContains('trademark', $response->json('visible'));
        $this->assertSame(310, $response->json('widths.trademark'));
        $stored = User::find(1)->results_columns;
        $this->assertSame($response->json(), $stored);
        $this->assertNull(User::find(2)->results_columns);
        $this->patchJson(route('account.results'), $preferences + ['user_id' => 2])->assertOk();
        $this->assertNull(User::find(2)->results_columns);
        $this->get(route('account.settings'))->assertOk()->assertSee('Results preferences');
        $this->patchJson(route('account.results'), array_replace($preferences, ['widths' => ['trademark' => 900]]))->assertUnprocessable();
        $this->patch(route('account.update'), ['name' => 'UI Review', 'email' => 'one@example.test', 'locale' => 'es'])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['id' => 1, 'preferred_locale' => 'es']);
        $this->get(route('changeLang', ['lang' => 'en']))->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => 1, 'preferred_locale' => 'en']);
        $this->app['auth']->user()->setAttribute('preferred_locale', 'es');
        $this->withSession(['locale' => 'en'])->get(route('index.trademarks'))->assertOk()->assertSee('lang="es"', false);
        $defaults = \App\Support\ResultsColumns::normalize(null);
        $this->patchJson(route('account.results'), $defaults)->assertOk()->assertExactJson($defaults);
    }

    public function test_page_size_is_validated_and_saved_for_future_requests(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->unsignedSmallInteger('trademark_results_per_page')->default(50); $table->timestamps();
        });
        DB::table('users')->insert(['id' => 1, 'name' => 'UI Review']);
        $user = $this->app['auth']->user();
        $user->exists = true;
        $user->setTable('users');
        Trademarks::create(['trademark' => 'Preference Test', 'status' => 'Registered']);
        $this->get(route('advance_search', ['per_page' => 25]))->assertOk();
        $this->assertDatabaseHas('users', ['id' => 1, 'trademark_results_per_page' => 25]);
        $user->setRawAttributes((array) DB::table('users')->where('id', 1)->first(), true);
        $response = $this->get(route('advance_search'))->assertOk();
        $this->assertSame(25, $response->viewData('trademarks')->perPage());
        $this->get(route('index.trademarks'))->assertOk()->assertSee('data-results-per-page="25"', false);
        $this->getJson(route('advance_search', ['per_page' => 10]))->assertUnprocessable()->assertJsonValidationErrors('per_page');
        $this->assertDatabaseHas('users', ['id' => 1, 'trademark_results_per_page' => 25]);
        $this->get(route('advance_search', ['per_page' => 100]))->assertOk();
        $this->assertDatabaseHas('users', ['id' => 1, 'trademark_results_per_page' => 100]);
    }

    public function test_new_task_and_event_forms_save_only_valid_user_owned_records(): void
    {
        $migration = require database_path('migrations/2026_11_06_000001_create_crm_activities.php');
        $migration->up();
        $this->get(route('tasks.create'))->assertOk()->assertSee('New Task');
        $this->get(route('events.create'))->assertOk()->assertSee('New Event');
        $this->post(route('tasks.store'), ['title' => 'Review file', 'created_by' => 99])->assertRedirect(route('tasks.create'));
        $this->assertDatabaseHas('crm_activities', ['kind' => 'task', 'title' => 'Review file', 'created_by' => 1]);
        $this->post(route('events.store'), ['title' => 'Meeting', 'starts_at' => '2026-11-06T10:00', 'ends_at' => '2026-11-06T11:00'])->assertRedirect(route('events.create'));
        $this->post(route('events.store'), ['title' => 'Invalid Meeting', 'starts_at' => '2026-11-06T11:00', 'ends_at' => '2026-11-06T10:00'])->assertSessionHasErrors('ends_at');
        $this->assertDatabaseCount('crm_activities', 2);
    }

    public function test_quick_search_requires_an_authenticated_session(): void
    {
        $this->app['auth']->guard()->logout();
        $this->getJson(route('trademarks.quick-search', ['number' => '13735']))->assertUnauthorized();
    }

    private function texts(\DOMNodeList $nodes): array
    {
        return array_map(fn ($node) => trim($node->textContent), iterator_to_array($nodes));
    }
}
