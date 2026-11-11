<?php
namespace App\Support;

class ResultsColumns
{
    public static function definitions(): array
    {
        $columns = [
            'select' => ['label' => '', 'width' => 44, 'fixed' => true],
            'edit' => ['label' => 'Edit', 'width' => 56, 'fixed' => true],
            'our_ref' => ['label' => 'Our Ref.', 'width' => 100, 'fixed' => true, 'type' => 'number'],
            'trademark' => ['label' => 'Trademark', 'width' => 220, 'fixed' => true],
            'class' => ['label' => 'Class', 'width' => 80, 'type' => 'number'],
            'application_no' => ['label' => 'Application No.', 'width' => 140, 'type' => 'number'],
            'registration_no' => ['label' => 'Registration No.', 'width' => 140, 'type' => 'number'],
            'registration_date' => ['label' => 'Registration Date', 'width' => 145, 'type' => 'date'],
            'last_declaration' => ['label' => 'Declaration of Use', 'width' => 150, 'type' => 'date'],
            'last_renewal' => ['label' => 'Renewal', 'width' => 130, 'type' => 'date'],
            'owner' => ['label' => 'Owner', 'width' => 220],
            'client' => ['label' => 'Client', 'width' => 220],
            'client_ref' => ['label' => 'Client Ref.', 'width' => 140, 'type' => 'number'],
            'origin' => ['label' => 'Department', 'width' => 140],
            'status' => ['label' => 'Status', 'width' => 120],
        ];
        if (app()->getLocale() === 'es') {
            $labels = ['edit' => 'Editar', 'our_ref' => 'Nuestra Ref.', 'trademark' => 'Marca', 'class' => 'Clase',
                'application_no' => 'Solicitud No.', 'registration_no' => 'Registro No.', 'registration_date' => 'Fecha de Registro',
                'last_declaration' => 'Declaración de Uso', 'last_renewal' => 'Renovación', 'owner' => 'Titular', 'client' => 'Cliente',
                'client_ref' => 'Ref. del Cliente', 'origin' => 'Departamento', 'status' => 'Estatus'];
            foreach ($labels as $key => $label) $columns[$key]['label'] = $label;
        }
        return $columns;
    }

    public static function normalize(?array $saved): array
    {
        $definitions = self::definitions();
        $fixed = array_slice(array_keys($definitions), 0, 4);
        $order = array_values(array_unique(array_merge($fixed, array_filter($saved['order'] ?? [], fn ($key) => isset($definitions[$key]) && !in_array($key, $fixed)), array_keys($definitions))));
        $visible = array_values(array_unique(array_merge($fixed, array_values(array_intersect($saved['visible'] ?? array_keys($definitions), array_keys($definitions))))));
        $widths = [];
        foreach ($definitions as $key => $column) $widths[$key] = max($key === 'select' ? 36 : 48, min(800, (int) ($saved['widths'][$key] ?? $column['width'])));
        return compact('order', 'visible', 'widths');
    }
}
