<?php

namespace App\Http\Controllers;

use App\Models\AddressContact;
use App\Models\Clients;
use App\Models\ContactClient;
use App\Models\PhoneContact;
use Illuminate\Http\Request;
use Session;
use DB;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('client.index');
    }

    public function advance(Request $request) {
        $clients = DB::table('clients');
        if( $request->company_name){
                $clients = $clients->where('company_name', 'LIKE', "%" . $request->company_name . "%");
        }
        if( $request->email){
            $clients = $clients->where('email', 'LIKE', "%" . $request->email . "%");
        }
        if( $request->vat_no){
            $clients = $clients->where('vat_no', 'LIKE', "%" . $request->vat_no . "%");
        }
        if( $request->country){
            $clients = $clients->where('country', 'LIKE', "%" . $request->country . "%");
        }
        $clients = $clients->paginate(10);

      return view('client.index', compact('clients'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = Clients::get();

        return view('client.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Clients;
        $client->company_name = $request->get('company_name');
        $client->vat_no = $request->get('vat_no');
        $client->country = $request->get('country');
        $client->web_page = $request->get('web_page');
        $client->email = $request->get('email2');
        $client->save();


        if($request->name != NULL){
            $name = $request->name;
            $short_name = $request->short_name;
            $position = $request->position;
            $email = $request->email;

            for ($count = 0; $count < count($name); $count++) {
                $data = array(
                    'name' => $name[$count],
                    'short_name' => $short_name[$count],
                    'position' => $position[$count],
                    'email' => $email[$count],
                    'id_client' => $client->id,
                );
                $insert_data[] = $data;
            }

            ContactClient::insert($insert_data);
        }

        if($request->phone != NULL){
            $phone = $request->phone;
            if($request->fax != NULL){
                $fax = $request->fax;
            }else{
                $fax = $request->phone;
            }

            for ($count = 0; $count < count($phone); $count++) {
                if($request->fax == NULL){
                    $data = array(
                        'phone' => $phone[$count],
                        'fax' => $fax[$count],
                        'id_clients' => $client->id,
                    );
                }else{
                    $data = array(
                        'phone' => $phone[$count],
                        'fax' => '-',
                        'id_clients' => $client->id,
                    );
                }

                $insert_data2[] = $data;
            }

            PhoneContact::insert($insert_data2);
        }

        if($request->address != NULL){
            $client_address = new AddressContact;
            $client_address->address = $request->get('address');

            if($request->billing_address != NULL){
                $client_address->billing_address = $request->get('billing_address');
            }else{
                $client_address->billing_address = $request->get('address');
            }

            $client_address->id_clients = $client->id;
            $client_address->save();
        }

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.clients')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Clients::find($id);
        $contacts = ContactClient::where('id_client', $client->id)->get();
        $address = AddressContact::where('id_clients', $id)->first();
        $phones = PhoneContact::where('id_clients', $client->id)->get();

        return view('client.edit', compact('client', 'contacts', 'address', 'phones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Clients::findOrFail($id);
        $client->company_name = $request->get('company_name');
        $client->vat_no = $request->get('vat_no');
        $client->country = $request->get('country');
        $client->web_page = $request->get('web_page');
        $client->email = $request->get('email');
        $client->update();

        $contact_client = ContactClient::where('id_client', $client->id)->delete();
        $phone_client = PhoneContact::where('id_clients', $client->id)->delete();

        if($request->name != NULL){
            $name = $request->name;
            $short_name = $request->short_name;
            $position = $request->position;
            $email = $request->email;

            for ($count = 0; $count < count($name); $count++) {
                $data = array(
                    'name' => $name[$count],
                    'short_name' => $short_name[$count],
                    'position' => $position[$count],
                    'email' => $email[$count],
                    'id_client' => $client->id,
                );
                $insert_data[] = $data;
            }

            ContactClient::insert($insert_data);
        }

        if($request->phone != NULL){
            $phone = $request->phone;
            if($request->fax != NULL){
                $fax = $request->fax;
            }else{
                $fax = $request->phone;
            }

            for ($count = 0; $count < count($phone); $count++) {
                if($request->fax == NULL){
                    $data = array(
                        'phone' => $phone[$count],
                        'fax' => $fax[$count],
                        'id_clients' => $client->id,
                    );
                }else{
                    $data = array(
                        'phone' => $phone[$count],
                        'fax' => '-',
                        'id_clients' => $client->id,
                    );
                }

                $insert_data2[] = $data;
            }

            PhoneContact::insert($insert_data2);
        }

        if($request->address != NULL){
            $client_address = AddressContact::where('id_clients', $client->id)->first();
            $client_address->address = $request->get('address');

            if($request->billing_address != NULL){
                $client_address->billing_address = $request->get('billing_address');
            }else{
                $client_address->billing_address = $request->get('address');
            }

            $client_address->id_clients = $client->id;
            $client_address->update();
        }

        Session::flash('edit', 'Se ha editado sus datos con exito');
        return redirect()->route('index.clients')
            ->with('success', 'Client updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact_client = ContactClient::findOrFail($id)->delete();
        $phone_client = PhoneContact::findOrFail($id)->delete();
        $address_client = AddressContact::findOrFail($id)->delete();
        $client = Clients::findOrFail($id)->delete();

        Session::flash('delete', 'Se ha eliminado sus datos con exito');
        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully');
    }
}
