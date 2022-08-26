<?php

namespace App\Http\Livewire\Trademarks;

use App\Models\Trademarks;
use Livewire\Component;

class Create extends Component
{
    public $client_ref, $notes, $our_ref, $opposition_no, $filing_date_opposition, $litigation_no, $filing_date_litigation, $application_no, $origin, $registration_no, $country,
    $filing_date_general, $status, $first_date, $int_registration_no, $registration_date, $int_registration_date, $expiration_date, $contracting_organization, $publication_date,
    $designated_countries, $last_declaration, $last_renewal, $next_declaration, $next_renewal, $trademark, $design, $description_trademark, $type_application, $type_mark, $translation,
    $transliteration_trademark, $disclaimer, $class, $translation_good, $description_good, $priority_no, $country_office, $priority_date, $client, $contact, $address, $holder,
    $address_holder, $industrial_address;

    public function save(){
        Trademarks::create([
            'client_ref' => $this->client_ref,
            'notes' => $this->notes,
            'our_ref' => $this->our_ref,
            'opposition_no' => $this->opposition_no,
            'filing_date_opposition' => $this->filing_date_opposition,
            'litigation_no' => $this->litigation_no,
            'filing_date_litigation' => $this->filing_date_litigation,
            'application_no' => $this->application_no,
            'origin' => $this->origin,
            'registration_no' => $this->registration_no,
            'country' => $this->country,
            'filing_date_general' => $this->filing_date_general,
            'status' => $this->status,
            'first_date' => $this->first_date,
            'int_registration_no' => $this->int_registration_no,
            'registration_date' => $this->registration_date,
            'int_registration_date' => $this->int_registration_date,
            'expiration_date' => $this->expiration_date,
            'contracting_organization' => $this->contracting_organization,
            'publication_date' => $this->publication_date,
        ]);
    }

    public function render()
    {
        return view('trademark.create')
        ->extends('layouts.app')
        ->section('content');
    }
}
