<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressHolder extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'address_holder';
    protected $fillable = ['id_holder',
                            'address',
                            'commercial_address'];
}
