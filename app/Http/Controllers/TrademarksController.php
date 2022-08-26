<?php

namespace App\Http\Controllers;

use App\Models\AddressContact;
use App\Models\Clients;
use App\Models\ContactClient;
use App\Models\Trademarks;
use Illuminate\Http\Request;

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

        return view('trademark.index', compact('trademarks', 'clients'));
    }

    public function contact(Request $request){
        if(isset($request->texto)){
            $contact = ContactClient::whereid_client($request->texto)->get();
            return response()->json(
                [
                    'lista' => $contact,
                    'success' => true
                ]
                );
        }else{
            return response()->json(
                [
                    'success' => false
                ]
                );

        }

    }

    public function address(Request $request){
        if(isset($request->texto)){
            $address = AddressContact::whereid_clients($request->texto)->get();
            return response()->json(
                [
                    'lista' => $address,
                    'success' => true
                ]
                );
        }else{
            return response()->json(
                [
                    'success' => false
                ]
                );

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trademarks = Trademarks::get();
        $clients = Clients::get();
        $address_contacts = AddressContact::get();

        return view('trademark.create', compact('clients', 'trademarks' , 'address_contacts'));
    }
}
