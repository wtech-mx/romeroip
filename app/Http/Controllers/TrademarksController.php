<?php

namespace App\Http\Controllers;

use App\Models\AddressContact;
use App\Models\Clients;
use App\Models\ContactClient;
use App\Models\Holder;
use App\Models\Trademarks;
use Illuminate\Http\Request;
use Session;
use DB;

class TrademarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trademarks = Trademarks::get();
        $clients = Clients::get();
        $holder = Holder::get();

        return view('trademark.index', compact('trademarks', 'clients', 'holder'));
    }

    /* Trae los contacto con el cliente seleccionado  */
    public function GetClientAgainstMainCatEdit($id)
    {
        echo json_encode(DB::table('contact_clients')->where('id_client', $id)->get());
    }

    /* Trae los contacto con el cliente seleccionado  */
    public function GetAddressAgainstMainCatEdit($id)
    {
        echo json_encode(DB::table('adress_clients')->where('id_clients', $id)->get());
    }

    /* Trae los contacto con el cliente seleccionado  */
    public function GetHolderAgainstMainCatEdit($id)
    {
        echo json_encode(DB::table('address_holder')->where('id_holder', $id)->get());
    }

    /* Trae los contacto con el cliente seleccionado  */
    public function GetHolderIAgainstMainCatEdit($id)
    {
        echo json_encode(DB::table('address_holder')->where('id_holder', $id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Clients::get();
        $address_contacts = AddressContact::get();
        $holders = Holder::get();

        return view('trademark.create', compact('clients', 'address_contacts', 'holders'));
    }

    public function store(Request $request)
    {
        $trademark = new Trademarks;
        $trademark->client_ref = $request->get('client_ref');
        $trademark->notes = $request->get('notes');
        $trademark->our_ref = $request->get('our_ref');
        $trademark->opposition_no = $request->get('opposition_no');
        $trademark->filing_date_opposition = $request->get('filing_date_opposition');
        $trademark->litigation_no = $request->get('litigation_no');
        $trademark->filing_date_litigation = $request->get('filing_date_litigation');
        $trademark->application_no = $request->get('application_no');
        $trademark->origin = $request->get('origin');
        $trademark->registration_no = $request->get('registration_no');
        $trademark->country = $request->get('country');
        $trademark->filing_date_general = $request->get('filing_date_general');
        $trademark->status = $request->get('status');
        $trademark->first_date = $request->get('first_date');
        $trademark->int_registration_no = $request->get('int_registration_no');
        $trademark->registration_date = $request->get('registration_date');
        $trademark->int_registration_date = $request->get('int_registration_date');
        $trademark->expiration_date = $request->get('expiration_date');
        $trademark->contracting_organization = $request->get('contracting_organization');
        $trademark->publication_date = $request->get('publication_date');
        $trademark->designated_countries = $request->get('designated_countries');
        $trademark->last_declaration = $request->get('last_declaration');
        $trademark->last_renewal = $request->get('last_renewal');
        $trademark->next_declaration = $request->get('next_declaration');
        $trademark->next_renewal = $request->get('next_renewal');
        $trademark->trademark = $request->get('trademark');
        $trademark->design = $request->get('design');
        $trademark->description_trademark = $request->get('description_trademark');
        $trademark->type_application = $request->get('type_application');
        $trademark->type_mark = $request->get('type_mark');
        $trademark->translation = $request->get('translation');
        $trademark->transliteration_trademark = $request->get('transliteration_trademark');
        $trademark->disclaimer = $request->get('disclaimer');
        $trademark->class = $request->get('class');
        $trademark->translation_good = $request->get('translation_good');
        $trademark->description_good = $request->get('description_good');
        $trademark->priority_no = $request->get('priority_no');
        $trademark->country_office = $request->get('country_office');
        $trademark->priority_date = $request->get('priority_date');
        $trademark->id_client = $request->get('id_client');
        $trademark->id_contact = $request->get('id_contact');
        $trademark->id_address = $request->get('id_address');
        $trademark->id_holder = $request->get('id_holder');
        $trademark->address_holder = $request->get('address_holder');
        $trademark->industrial_address = $request->get('industrial_address');
        $trademark->save();

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.trademarks')
            ->with('success', 'holder created successfully.');
    }
}
