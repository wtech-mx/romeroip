<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneContact extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'phone_clients';
    protected $fillable = ['id_clients',
                            'phone',
                            'fax'];
}
