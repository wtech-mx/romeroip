<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'clients';
    protected $fillable = ['company_name',
                            'vat_no',
                            'country',
                            'notes'];

    public function ContactClient(){
        return $this->hasOne('App\Models\ContactClient', 'id_client');
    }
    
    public function AddressContact(){
        return $this->hasOne('App\Models\AddressContact', 'id_clients');
    }
}
