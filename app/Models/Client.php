<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @property $id
 * @property $nombre
 * @property $apellido
 * @property $edad
 * @property $sanguineo
 * @property $ocupacion
 * @property $telefono
 * @property $fecha_nacimiento
 * @property $email
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
		'apellido' => 'required',
		'telefono' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','apellido','edad','sanguineo','ocupacion','telefono','fecha_nacimiento','email'];



}
