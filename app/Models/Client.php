<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @property $id
 * @property $nombre
 * @property $nombre_corto
 * @property $rfc
 * @property $pais
 * @property $posicion
 * @property $pagina_web
 * @property $nombre_compañia
 * @property $email
 * @property $notas
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Client extends Model
{

    static $rules = [
		'nombre' => 'required',
		'rfc' => 'required',
		'posicion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','nombre_corto','rfc','pais','posicion','pagina_web','email','notas','nombre_compañia'];



}
