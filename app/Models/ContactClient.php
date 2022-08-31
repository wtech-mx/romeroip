<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactClient extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'contact_clients';
    protected $fillable = ['id_client',
                            'name',
                            'short_name',
                            'position',
                            'email'];
}
