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
            'address_holder' => ['id_holder', 'address', 'commercial_address'],
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
        $this->post(route('store.trademarks'), ['trademark' => 'Navigation Test', 'our_ref' => '13545', 'client_ref' => $reference, 'type_mark' => 'Three-Dimensional Mark'])
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
        Schema::create('users', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('email'); $table->timestamps(); });
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
