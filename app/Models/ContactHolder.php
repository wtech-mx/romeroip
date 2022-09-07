<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactHolder extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'contact_holder';
    protected $fillable = ['id_holder',
                            'phone',
                            'fax'];
}
