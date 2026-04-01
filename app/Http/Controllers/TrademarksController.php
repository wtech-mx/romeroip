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

    public function advance(Request $request)
    {
        try {
            $filters = $request->validate([
                'client_ref'          => ['nullable', 'string', 'max:100'],
                'application_no'      => ['nullable', 'string', 'max:100'],
                'registration_no'     => ['nullable', 'string', 'max:100'],
                'int_registration_no' => ['nullable', 'string', 'max:100'],
                'origin'              => ['nullable', 'string', 'max:50'],
                'id_client'           => ['nullable', 'string', 'max:255'],
                'id_holder'           => ['nullable', 'string', 'max:255'],
                'trademark'           => ['nullable', 'string', 'max:255'],
                'status'              => ['nullable', 'string', 'max:50'],
                'opposition_no'       => ['nullable', 'string', 'max:100'],
                'litigation_no'       => ['nullable', 'string', 'max:100'],
                'class'               => ['nullable', 'string', 'max:10'],
                'country'             => ['nullable', 'string', 'max:100'],
                'national'            => ['nullable', 'string', 'max:100'],
                'last_declaration'    => ['nullable', 'date'],
                'next_declaration'    => ['nullable', 'date'],
                'last_renewal'        => ['nullable', 'date'],
                'next_renewal'        => ['nullable', 'date'],
                'from_refs'           => ['nullable', 'integer'],
                'to_refs'             => ['nullable', 'integer'],
            ]);

            $trademarks = Trademarks::query()
                ->with([
                    'Client:id,company_name',
                    'Holder:id,company_name',
                ])

                ->when(!empty($filters['client_ref']), function ($query) use ($filters) {
                    $value = trim($filters['client_ref']);

                    $query->where(function ($q) use ($value) {
                        $q->where('client_ref', 'like', "%{$value}%")
                        ->orWhere('our_ref', 'like', "%{$value}%");
                    });
                })

                ->when(!empty($filters['application_no']), fn ($query) =>
                    $query->where('application_no', 'like', '%' . trim($filters['application_no']) . '%')
                )

                ->when(!empty($filters['registration_no']), fn ($query) =>
                    $query->where('registration_no', 'like', '%' . trim($filters['registration_no']) . '%')
                )

                ->when(!empty($filters['int_registration_no']), fn ($query) =>
                    $query->where('int_registration_no', 'like', '%' . trim($filters['int_registration_no']) . '%')
                )

                ->when(!empty($filters['origin']), fn ($query) =>
                    $query->where('origin', $filters['origin'])
                )

                ->when(!empty($filters['id_client']), function ($query) use ($filters) {
                    $value = trim($filters['id_client']);

                    $query->whereHas('Client', function (Builder $q) use ($value) {
                        $q->where('company_name', 'like', "%{$value}%");
                    });
                })

                ->when(!empty($filters['id_holder']), function ($query) use ($filters) {
                    $value = trim($filters['id_holder']);

                    $query->whereHas('Holder', function (Builder $q) use ($value) {
                        $q->where('company_name', 'like', "%{$value}%");
                    });
                })

                ->when(!empty($filters['trademark']), fn ($query) =>
                    $query->where('trademark', 'like', '%' . trim($filters['trademark']) . '%')
                )

                ->when(!empty($filters['status']), fn ($query) =>
                    $query->where('status', $filters['status'])
                )

                ->when(!empty($filters['opposition_no']), fn ($query) =>
                    $query->where('opposition_no', 'like', '%' . trim($filters['opposition_no']) . '%')
                )

                ->when(!empty($filters['litigation_no']), fn ($query) =>
                    $query->where('litigation_no', 'like', '%' . trim($filters['litigation_no']) . '%')
                )

                ->when(!empty($filters['class']), fn ($query) =>
                    $query->where('class', $filters['class'])
                )

                ->when(!empty($filters['country']), fn ($query) =>
                    $query->where('country', $filters['country'])
                )

                ->when(!empty($filters['national']), fn ($query) =>
                    $query->where('national', $filters['national'])
                )

                ->when(
                    !empty($filters['last_declaration']) && !empty($filters['next_declaration']),
                    fn ($query) =>
                        $query->whereBetween('last_declaration', [
                            $filters['last_declaration'],
                            $filters['next_declaration']
                        ])
                )

                ->when(
                    !empty($filters['last_renewal']) && !empty($filters['next_renewal']),
                    fn ($query) =>
                        $query->whereBetween('last_renewal', [
                            $filters['last_renewal'],
                            $filters['next_renewal']
                        ])
                )

                ->when(
                    isset($filters['from_refs']) && isset($filters['to_refs']) &&
                    $filters['from_refs'] !== null && $filters['to_refs'] !== null,
                    fn ($query) =>
                        $query->whereBetween('our_ref', [
                            $filters['from_refs'],
                            $filters['to_refs']
                        ])
                )

                ->orderByDesc('id');

            $trademarks = $trademarks
                ->paginate(10)
                ->appends($request->query());

            if ($trademarks->isEmpty()) {
                return view('trademark.index', compact('trademarks'))
                    ->with('info', 'No records were found with the selected filters.');
            }

            return view('trademark.index', compact('trademarks'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('swal_error', 'Please review the search filters.');

        } catch (\Throwable $e) {
            Log::error('Trademark advance search failed', [
                'message' => $e->getMessage(),
                'filters' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('swal_error', 'An unexpected error occurred while searching. Please try again.');
        }
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

            'id_client'               => 'nullable|exists:clients,id',
            'id_contact'              => 'nullable|exists:contact_clients,id',
            'id_address'              => 'nullable|exists:adress_clients,id',
            'id_holder'               => 'nullable|exists:holder,id',
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
        $trademark = Trademarks::with([
            'Client:id,company_name',
            'Holder:id,company_name',
            'ContactClient:id,name',
            'AddressContact:id,address',
            'AddressHolder:id,address',
        ])->findOrFail($id);

        return view('trademark.edit', compact('trademark'));
    }

    public function update(Request $request, $id)
    {
        try {
            $trademark = Trademarks::findOrFail($id);

            $data = $request->validate($this->trademarkRules($trademark->id));

            $this->fillTrademarkFromRequest($trademark, $data, $request);
            $trademark->save();

            return redirect()
                ->route('index.trademarks')
                ->with('success', 'Trademark updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Trademark update failed', [
                'trademark_id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('swal_error', 'An unexpected error occurred while updating the trademark.');
        }
    }

    public function searchClientRef(Request $request)
    {
        $term = trim((string) $request->get('q', ''));

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $results = \App\Models\Trademarks::query()
            ->select('id', 'client_ref', 'our_ref')
            ->where(function ($query) use ($term) {
                $query->where('client_ref', 'like', "%{$term}%")
                    ->orWhere('our_ref', 'like', "%{$term}%");
            })
            ->orderByDesc('id')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'value' => $item->client_ref ?: $item->our_ref,
                    'title' => $item->client_ref ?: $item->our_ref,
                    'subtitle' => 'Our Ref: ' . ($item->our_ref ?? '-'),
                ];
            });

        return response()->json($results);
    }

    public function searchTrademarkName(Request $request)
    {
        $term = trim((string) $request->get('q', ''));

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $results = \App\Models\Trademarks::query()
            ->select('id', 'trademark', 'client_ref')
            ->where('trademark', 'like', "%{$term}%")
            ->orderBy('trademark')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'value' => $item->trademark,
                    'title' => $item->trademark,
                    'subtitle' => 'Client Ref: ' . ($item->client_ref ?? '-'),
                ];
            });

        return response()->json($results);
    }

    public function searchClientsAutocomplete(Request $request)
    {
        $term = trim((string) $request->get('q', ''));

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $results = \App\Models\Clients::query()
            ->select('id', 'company_name')
            ->where('company_name', 'like', "%{$term}%")
            ->orderBy('company_name')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'value' => $item->company_name,
                    'title' => $item->company_name,
                    'subtitle' => 'ID: ' . $item->id,
                ];
            });

        return response()->json($results);
    }

    public function searchHoldersAutocomplete(Request $request)
    {
        $term = trim((string) $request->get('q', ''));

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $results = \App\Models\Holder::query()
            ->select('id', 'company_name')
            ->where('company_name', 'like', "%{$term}%")
            ->orderBy('company_name')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'value' => $item->company_name,
                    'title' => $item->company_name,
                    'subtitle' => 'ID: ' . $item->id,
                ];
            });

        return response()->json($results);
    }
}
