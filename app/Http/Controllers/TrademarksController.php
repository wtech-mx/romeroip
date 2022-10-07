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
use Illuminate\Contracts\Database\Eloquent\Builder;

class TrademarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index() {


      return view('trademark.index');
     }

     public function advance(Request $request) {
        $trademarks = DB::table('trademark');
        $marca = Trademarks::get();
        if( $request->client_ref){
                $trademarks = $trademarks->where('client_ref', 'LIKE', "%" . $request->client_ref . "%")
                                         ->orWhere('our_ref', 'LIKE', "%" . $request->client_ref . "%");
        }
        if( $request->application_no){
            $trademarks = $trademarks->where('application_no', 'LIKE', "%" . $request->application_no . "%");
        }
        if( $request->registration_no){
            $trademarks = $trademarks->where('registration_no', 'LIKE', "%" . $request->registration_no . "%");
        }
        if( $request->int_registration_no){
            $trademarks = $trademarks->where('int_registration_no', 'LIKE', "%" . $request->int_registration_no . "%");
        }
        if( $request->origin){
            $trademarks = $trademarks->where('origin', 'LIKE', "%" . $request->origin . "%");
        }
        if( $request->id_client){
            $id_client = $request->id_client;
            $trademarks = Trademarks::whereHas('Client', function(Builder $query) use($id_client) {
                     $query->where('company_name', $id_client);
            });
        }
        if( $request->id_holder){
            $id_holder = $request->id_holder;
            $trademarks = Trademarks::whereHas('Holder', function(Builder $query) use($id_holder) {
                        $query->where('company_name', $id_holder);
            });
        }
        if( $request->trademark){
            $trademarks = $trademarks->where('trademark', 'LIKE', "%" . $request->trademark . "%");
        }
        if( $request->status){
            $trademarks = $trademarks->where('status', 'LIKE', "%" . $request->status . "%");
        }
        if( $request->opposition_no){
            $trademarks = $trademarks->where('opposition_no', 'LIKE', "%" . $request->opposition_no . "%");
        }
        if( $request->litigation_no){
            $trademarks = $trademarks->where('litigation_no', 'LIKE', "%" . $request->litigation_no . "%");
        }
        if( $request->class){
            $trademarks = $trademarks->where('class', 'LIKE', "%" . $request->class . "%");
        }
        if( $request->country){
            $trademarks = $trademarks->where('country', 'LIKE', "%" . $request->country . "%");
        }
        if( $request->last_declaration && $request->next_declaration ){
            $trademarks = $trademarks->where('last_declaration', '>=', $request->last_declaration)
                                     ->where('last_declaration', '<=', $request->next_declaration);
        }
        if( $request->last_renewal && $request->next_renewal ){
            $trademarks = $trademarks->where('last_renewal', '>=', $request->last_renewal)
                                     ->where('last_renewal', '<=', $request->next_renewal);
        }
        if( $request->from_refs && $request->to_refs ){
            $trademarks = $trademarks->where('our_ref', '>=', $request->from_refs)
                                     ->where('our_ref', '<=', $request->to_refs);
        }
        $trademarks = $trademarks->paginate(10);

      return view('trademark.index', compact('trademarks'));
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

        $trademark = Trademarks::
        orderBy('id', 'desc')
        ->first();

        return view('trademark.create', compact('clients', 'address_contacts', 'holders', 'trademark'));
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

        if ($request->hasFile("design")) {
            $file = $request->file('design');
            $path = public_path() . '/design';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);

            $trademark->design = $fileName;
        }

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

    public function edit($id)
    {
        $clients = Clients::get();
        $address_contacts = AddressContact::get();
        $holders = Holder::get();
        $trademark = Trademarks::find($id);

        return view('trademark.edit', compact('clients', 'address_contacts', 'holders', 'trademark'));
    }

    public function update(Request $request, $id)
    {
        $trademark = Trademarks::findOrFail($id);
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
        if ($request->hasFile("design")) {
            $file = $request->file('design');
            $path = public_path() . '/design';
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($path, $fileName);

            $trademark->design = $fileName;
        }
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
        $trademark->update();

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.trademarks')
            ->with('success', 'holder created successfully.');
    }
}
