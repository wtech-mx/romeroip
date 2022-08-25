<?php

namespace App\Http\Controllers;

use App\Models\AddressContact;
use App\Models\Clients;
use App\Models\ContactClient;
use App\Models\PhoneContact;
use Illuminate\Http\Request;
use Session;

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
    public function index()
    {
        $clients = Clients::get();

        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Clients();

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
        $client->notes = $request->get('notes');
        $client->save();

        $name = $request->name;
        $short_name = $request->short_name;
        $position = $request->position;
        $email = $request->email;
        $web_page = $request->web_page;

        for ($count = 0; $count < count($name); $count++) {
            $data = array(
                'name' => $name[$count],
                'short_name' => $short_name[$count],
                'position' => $position[$count],
                'email' => $email[$count],
                'web_page' => $web_page[$count],
                'id_client' => $client->id,
            );
            $insert_data[] = $data;
        }

        ContactClient::insert($insert_data);

        $phone = $request->phone;
        $fax = $request->fax;

        for ($count = 0; $count < count($phone); $count++) {
            $data = array(
                'phone' => $phone[$count],
                'fax' => $fax[$count],
                'id_clients' => $client->id,
            );
            $insert_data2[] = $data;
        }

        PhoneContact::insert($insert_data2);

        $address = $request->address;
        $billing_address = $request->billing_address;

        for ($count = 0; $count < count($address); $count++) {
            $data = array(
                'address' => $address[$count],
                'billing_address' => $billing_address[$count],
                'id_clients' => $client->id,
            );
            $insert_data3[] = $data;
        }

        AddressContact::insert($insert_data3);

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
        $address = AddressContact::where('id_clients', $client->id)->get();
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
        $client->notes = $request->get('notes');
        $client->update();

        $contact_client = ContactClient::where('id_client', $client->id)->delete();
        $phone_client = PhoneContact::where('id_clients', $client->id)->delete();
        $address_client = AddressContact::where('id_clients', $client->id)->delete();

        $name = $request->name;
        $short_name = $request->short_name;
        $position = $request->position;
        $email = $request->email;
        $web_page = $request->web_page;

        for ($count = 0; $count < count($name); $count++) {
            $data = array(
                'name' => $name[$count],
                'short_name' => $short_name[$count],
                'position' => $position[$count],
                'email' => $email[$count],
                'web_page' => $web_page[$count],
                'id_client' => $client->id,
            );
            $insert_data[] = $data;
        }

        ContactClient::insert($insert_data);

        $phone = $request->phone;
        $fax = $request->fax;

        for ($count = 0; $count < count($phone); $count++) {
            $data = array(
                'phone' => $phone[$count],
                'fax' => $fax[$count],
                'id_clients' => $client->id,
            );
            $insert_data2[] = $data;
        }

        PhoneContact::insert($insert_data2);

        $address = $request->address;
        $billing_address = $request->billing_address;

        for ($count = 0; $count < count($address); $count++) {
            $data = array(
                'address' => $address[$count],
                'billing_address' => $billing_address[$count],
                'id_clients' => $client->id,
            );
            $insert_data3[] = $data;
        }

        AddressContact::insert($insert_data3);

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
