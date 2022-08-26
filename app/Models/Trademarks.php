<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trademarks extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'trademark';
    protected $fillable = ['client_ref',
                            'notes',
                            'our_ref',
                            'opposition_no',
                            'filing_date_opposition',
                            'litigation_no',
                            'filing_date_litigation',
                            'application_no',
                            'origin',
                            'registration_no',
                            'country',
                            'filing_date_general',
                            'status',
                            'first_date',
                            'int_registration_no',
                            'registration_date',
                            'int_registration_date',
                            'expiration_date',
                            'contracting_organization',
                            'publication_date',
                            'designated_countries',
                            'last_declaration',
                            'last_renewal',
                            'next_declaration',
                            'next_renewal',
                            'trademark',
                            'design',
                            'description_trademark',
                            'type_application',
                            'type_mark',
                            'translation',
                            'transliteration_trademark',
                            'disclaimer',
                            'class',
                            'translation_good',
                            'description_good',
                            'priority_no',
                            'country_office',
                            'priority_date',
                            'id_client',
                            'id_contact',
                            'id_address',
                            'industrial_address'];

    public function Clients(){
        return $this->belongsTo(Clients::class,'id_client');
    }

    public function ContactClient(){
        return $this->belongsTo(ContactClient::class,'id_contact');
    }

    public function AddressContact(){
        return $this->belongsTo(AddressContact::class,'id_address');
    }

}
