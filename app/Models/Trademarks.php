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

    public function Client(){
        return $this->hasOne(Client::class,'id_client');
    }

    public function Holder(){
        return $this->belongsTo(Holder::class,'id_holder');
    }

    public function AddressContact(){
        return $this->belongsTo(AddressContact::class,'id_address');
    }

    // ========================================================Filtros====================================================================

    public function scopeClient_ref($query, $client_ref) {
    	if ($client_ref) {
    		return $query->where('client_ref','like',"%$client_ref%");
    	}
    }
    public function scopeApplication_no($query, $application_no) {
    	if ($application_no) {
    		return $query->where('application_no','like',"%$application_no%");
    	}
    }
    public function scopeRegistration_no($query, $registration_no) {
    	if ($registration_no) {
    		return $query->where('registration_no','like',"%$registration_no%");
    	}
    }
    public function scopeInt_registration_no($query, $int_registration_no) {
    	if ($int_registration_no) {
    		return $query->where('int_registration_no','like',"%$int_registration_no%");
    	}
    }
    public function scopeOrigin($query, $origin) {
    	if ($origin) {
    		return $query->where('origin','like',"%$origin%");
    	}
    }
    public function scopeTrademark($query, $trademark) {
    	if ($trademark) {
    		return $query->where('trademark','like',"%$trademark%");
    	}
    }
}
