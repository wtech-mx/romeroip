<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'clients';
    protected $fillable = [
        'company_name',
        'vat_no',
        'country',
        'notes',
        'web_page'
    ];

    public function ContactClient()
    {
        return $this->hasOne('App\Models\ContactClient', 'id_client');
    }

    public function AddressContact()
    {
        return $this->hasOne('App\Models\AddressContact', 'id_clients');
    }

    public function scopeCompanyName($query, $company_name)
    {
        if($company_name)
            return $query->where('company_name', 'LIKE', "%$company_name%");
    }

    public function scopeVatNo($query, $vat_no)
    {
        if($vat_no)
            return $query->where('vat_no', 'LIKE', "%$vat_no%");
    }
}
