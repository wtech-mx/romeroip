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

use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

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

private function trademarkRules(?int $id = null): array
{
    return [
        'notes'                   => 'nullable|string',
        'our_ref'                 => ['required', 'integer', 'min:1', Rule::unique('trademark', 'our_ref')->ignore($id)],
        'client_ref'              => 'nullable|string|max:100',
        'opposition_no'           => 'nullable|string|max:100',
        'filing_date_opposition'  => 'nullable|date',
        'litigation_no'           => 'nullable|string|max:100',
        'filing_date_litigation'  => 'nullable|date',
        'application_no'          => 'nullable|string|max:100',
        'origin'                  => 'nullable|string|max:50',
        'registration_no'         => 'nullable|string|max:100',
        'country'                 => 'nullable|string|max:150',
        'filing_date_general'     => 'nullable|date',
        'status'                  => 'required|string|max:50',
        'first_date'              => 'nullable|date',
        'int_registration_no'     => 'nullable|string|max:100',
        'registration_date'       => 'nullable|date',
        'int_registration_date'   => 'nullable|date',
        'expiration_date'         => 'nullable|date',
        'contracting_organization'=> 'nullable|string|max:255',
        'publication_date'        => 'nullable|date',
        'designated_countries'    => 'nullable|string|max:255',
        'last_declaration'        => 'nullable|date',
        'last_renewal'            => 'nullable|date',
        'next_declaration'        => 'nullable|date',
        'next_renewal'            => 'nullable|date',
        'trademark'               => 'required|string|max:255',
        'description_trademark'   => 'nullable|string',
        'type_application'        => 'nullable|string|max:100',
        'type_mark'               => 'nullable|string|max:100',
        'translation'             => 'nullable|string',
        'transliteration_trademark'=> 'nullable|string',
        'disclaimer'              => 'nullable|string',
        'class'                   => 'nullable|integer|min:1|max:45',
        'translation_good'        => 'nullable|string',
        'description_good'        => 'nullable|string',
        'priority_no'             => 'nullable|string|max:100',
        'country_office'          => 'nullable|string|max:150',
        'priority_date'           => 'nullable|date',

        'id_client'               => 'required|exists:clients,id',
        'id_contact'              => 'nullable|exists:contact_clients,id',
        'id_address'              => 'nullable|exists:adress_clients,id',
        'id_holder'               => 'required|exists:holder,id',
        'address_holder'          => 'nullable|exists:address_holder,id',
        'industrial_address'      => 'nullable|string|max:255',

        'design'                  => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096',
    ];
}

    private function fillTrademarkFromRequest(Trademarks $trademark, array $data, Request $request): void
    {
        $fields = [
            'client_ref',
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
            'id_holder',
            'address_holder',
            'industrial_address',
        ];

        foreach ($fields as $field) {
            $trademark->{$field} = $data[$field] ?? null;
        }

        if ($request->hasFile('design')) {
            $file = $request->file('design');
            $path = public_path('design');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $fileName = uniqid('trademark_') . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);

            $trademark->design = $fileName;
        }
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
        $data = $request->validate($this->trademarkRules());

        $trademark = new Trademarks();
        $this->fillTrademarkFromRequest($trademark, $data, $request);
        $trademark->save();

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.trademarks')
            ->with('success', 'Trademark created successfully.');
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

        $data = $request->validate($this->trademarkRules($trademark->id));

        $this->fillTrademarkFromRequest($trademark, $data, $request);
        $trademark->save();

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.trademarks')
            ->with('success', 'Trademark updated successfully.');
    }
}
