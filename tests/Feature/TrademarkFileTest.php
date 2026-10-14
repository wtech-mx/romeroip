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
        $this->assertCount(15, $showLabels);
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
            $this->assertSame([8, 7], array_map(fn ($column) => $document->query('.//*[contains(@class,"tm-label")]', $column)->length,
                iterator_to_array($document->query('//section[@id="general"]//*[contains(@class,"tm-field-column")]'))));
            $this->assertSame(1, $document->query('//section[@id="references"]//*[contains(@class,"tm-label") and contains(.,"Department")]')->length);
            $this->assertSame(1, $document->query('//section[@id="general"]//*[contains(@class,"tm-label") and normalize-space(.)="Country / Office"]')->length);
        }
    }

    private function texts(\DOMNodeList $nodes): array
    {
        return array_map(fn ($node) => trim($node->textContent), iterator_to_array($nodes));
    }
}
