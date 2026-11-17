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

    private function ownerData(Request $request): array
    {
        return $request->validate([
            'owner_type' => 'sometimes|required|in:Company,Individual',
            'company_name' => 'required|string|max:255', 'country' => 'nullable|string|max:255', 'notas' => 'sometimes|nullable|string',
            'rfc' => 'sometimes|nullable|string|max:30', 'curp' => 'sometimes|nullable|string|max:30',
            'sex' => 'sometimes|nullable|in:Female,Male,Other', 'date_of_birth' => 'sometimes|nullable|date_format:Y-m-d|before_or_equal:today',
            'place_of_birth' => 'sometimes|nullable|string|max:255',
            'telephone' => 'sometimes|nullable|string|max:60', 'extension' => 'sometimes|nullable|string|max:20',
            'mobile' => 'sometimes|nullable|string|max:60', 'email' => 'sometimes|nullable|email|max:255',
            'address' => 'nullable|array', 'address.*' => 'nullable|string',
            'commercial_address' => 'nullable|array', 'commercial_address.*' => 'nullable|string',
            'address_ids' => 'nullable|array', 'address_ids.*' => 'nullable|integer|distinct',
        ]);
    }

    private function saveAddresses(Holder $holder, array $data): void
    {
        $existing = AddressHolder::where('id_holder', $holder->id)->orderBy('id')->get();
        foreach (($data['address'] ?? []) as $index => $address) {
            $addressId = $data['address_ids'][$index] ?? null;
            // Existing addresses keep their IDs, including those referenced by trademarks.
            $row = $addressId
                ? AddressHolder::where('id_holder', $holder->id)->findOrFail($addressId)
                : ($existing[$index] ?? new AddressHolder(['id_holder' => $holder->id]));
            $row->address = $address;
            $row->commercial_address = array_key_exists($index, $data['commercial_address'] ?? []) ? $data['commercial_address'][$index] : $address;
            $row->save();
        }
    }

    public function store(Request $request)
    {
        $data = $this->ownerData($request);
        \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            $holder = Holder::create(collect($data)->except(['address', 'commercial_address', 'address_ids'])->all());
            $this->saveAddresses($holder, $data);
        });
        return redirect()->route('index.holder')->with('success', 'Owner created successfully.');
    }

    public function edit($id)
    {
        $holder = Holder::findOrFail($id);
        $address_holder = AddressHolder::where('id_holder', $id)->get();

        return view('holder.edit', compact('holder', 'address_holder'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->ownerData($request);
        \Illuminate\Support\Facades\DB::transaction(function () use ($id, $data) {
            $holder = Holder::findOrFail($id);
            $holder->update(collect($data)->except(['address', 'commercial_address', 'address_ids'])->all());
            $this->saveAddresses($holder, $data);
        });
        return redirect()->route('index.holder')->with('success', 'Owner updated successfully.');
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
