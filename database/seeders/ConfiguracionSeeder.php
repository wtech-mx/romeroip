<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuracion = Configuracion::create([
            'nombre_sistema' => 'Sistema WebTech',
            'color_principal' => '#2ba3ee',
            'logo' => '62c7b5166ea00W-TECHBL6.png',
            'favicon' => '62c7b5166f3b7LogosinF.png',
            'color_iconos_sidebar' => '#5bb9e1',
            'color_iconos_cards' => '#ffffff',
            'color_boton_add' => '#000000',
            'color_boton_save' => '#029400',
            'color_boton_close' => '#850000',
        ]);
    }
}
