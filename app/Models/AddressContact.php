<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressContact extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'adress_clients';
    protected $fillable = ['id_clients',
                            'address',
                            'billing_address'];
}
