<?php

namespace App\Support;

class TrademarkFileLayout
{
    private static function field(string $key, string $label, string $type = 'text', array $options = []): array
    {
        return array_merge([
            'key' => $key, 'id' => $key, 'label' => $label, 'type' => $type,
            'emphasis' => false, 'spacer' => false, 'limit' => null, 'default' => null,
        ], $options);
    }

    public static function sections(): array
    {
        return [
            ['id' => 'references', 'number' => '01', 'title' => 'References', 'columns' => [
                [self::field('our_ref', 'Our Reference', 'text', ['limit' => 5, 'emphasis' => true]),
                 self::field('client_ref', 'Client Reference', 'text', ['limit' => 20, 'emphasis' => true])],
                [self::field('origin', 'Department', 'origin')],
            ]],
            ['id' => 'general', 'number' => '02', 'title' => 'General', 'columns' => [
                [self::field('application_no', 'Application No.', 'text', ['limit' => 10]),
                 self::field('filing_date_general', 'Filing Date', 'date'),
                 self::field('registration_no', 'Registration No.', 'text', ['limit' => 10, 'emphasis' => true]),
                 self::field('registration_date', 'Registration Date', 'date', ['id' => 'registrationDate', 'spacer' => true]),
                 self::field('first_date', 'First Use Date', 'date', ['spacer' => true]),
                 self::field('expiration_date', 'Expiration Date', 'date', ['id' => 'expirationDate', 'emphasis' => true]),
                 self::field('country', 'Country / Office', 'country', ['default' => 'Mexico', 'spacer' => true]),
                 self::field('status', 'Status', 'status')],
                [self::field('priority_no', 'Priority Application No.'),
                 self::field('priority_date', 'Priority Date', 'date'),
                 self::field('country_office', 'Priority Country / Office', 'country', ['spacer' => true]),
                 self::field('int_registration_no', "Int'l Registration No."),
                 self::field('int_registration_date', "Int'l Registration Date", 'date', ['spacer' => true]),
                 self::field('contracting_organization', 'Contracting Party', 'country'),
                 self::field('designated_countries', 'Designated Countries', 'text', ['limit' => 255, 'spacer' => true]),
                 self::field('int_renewal_date', "Int'l Renewal Date", 'date')],
            ]],
            ['id' => 'maintenance', 'number' => '03', 'title' => 'Maintenance', 'columns' => [
                [self::field('last_declaration', 'Last Declaration of Use', 'date', ['id' => 'lastDeclarationDate']),
                 self::field('last_renewal', 'Last Renewal', 'date', ['id' => 'lastRenewalsDate'])],
                [self::field('next_declaration', 'Next Declaration of Use', 'date', ['id' => 'declarationOfUseDate', 'emphasis' => true]),
                 self::field('next_renewal', 'Next Renewal', 'date', ['id' => 'renewalDate', 'emphasis' => true])],
            ]],
        ];
    }
}
