<?php

namespace App\Http\Controllers;

use App\Models\AddressHolder;
use App\Models\Holder;
use Illuminate\Http\Request;
use Session;

class HolderController extends Controller
{

    public function index()
    {
        $holder = Holder::get();

        return view('holder.index', compact('holder'));
    }

    public function create()
    {
        $holder = Holder::get();

        return view('holder.create', compact('holder'));
    }

    public function store(Request $request)
    {
        $holder = new Holder;
        $holder->company_name = $request->get('company_name');
        $holder->country = $request->get('country');
        $holder->notas = $request->get('notas');
        $holder->save();

        if($request->address != NULL){
            $address = $request->address;
            if($request->commercial_address != NULL){
                $commercial_address = $request->commercial_address;
            }else{
                $commercial_address = $request->address;
            }

            for ($count = 0; $count < count($address); $count++) {
                if($request->commercial_address == NULL){
                    $data = array(
                        'address' => $address[$count],
                        'commercial_address' => $commercial_address[$count],
                        'id_holder' => $holder->id,
                    );
                }else{
                    $data = array(
                        'address' => $address[$count],
                        'commercial_address' => $address[$count],
                        'id_holder' => $holder->id,
                    );
                }

                $insert_data[] = $data;
            }

            AddressHolder::insert($insert_data);
        }

        Session::flash('success', 'Se ha guardado sus datos con exito');
        return redirect()->route('index.holder')
            ->with('success', 'holder created successfully.');
    }

    public function edit($id)
    {
        $holder = Holder::find($id);
        $address_holder = AddressHolder::where('id_holder', $id)->get();

        return view('holder.edit', compact('holder', 'address_holder'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
            'address' => 'nullable|array', 'address.*' => 'nullable|string',
            'commercial_address' => 'nullable|array', 'commercial_address.*' => 'nullable|string',
            'address_ids' => 'nullable|array', 'address_ids.*' => 'nullable|integer',
        ]);
        \Illuminate\Support\Facades\DB::transaction(function () use ($id, $data) {
            $holder = Holder::findOrFail($id);
            $holder->update(collect($data)->only(['company_name', 'country', 'notas'])->all());
            $existing = AddressHolder::where('id_holder', $holder->id)->orderBy('id')->get();
            foreach (($data['address'] ?? []) as $index => $address) {
                $addressId = $data['address_ids'][$index] ?? null;
                $row = $addressId
                    ? AddressHolder::where('id_holder', $holder->id)->findOrFail($addressId)
                    : ($existing[$index] ?? new AddressHolder(['id_holder' => $holder->id]));
                $row->address = $address;
                $row->commercial_address = $data['commercial_address'][$index] ?? $address;
                $row->save();
            }
        });

        Session::flash('edit', 'Se ha editado sus datos con exito');
        return redirect()->route('index.holder')
            ->with('success', 'Holder updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact_holder = AddressHolder::findOrFail($id)->delete();
        $address_holder = ContactHolder::findOrFail($id)->delete();
        $holder = Holder::findOrFail($id)->delete();

        Session::flash('delete', 'Se ha eliminado sus datos con exito');
        return redirect()->route('holder.index')
            ->with('success', 'Client deleted successfully');
    }
}
