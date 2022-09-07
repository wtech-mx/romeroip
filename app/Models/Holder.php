<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holder extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'holder';
    protected $fillable = ['company_name',
                            'country',
                            'notas'];
}
