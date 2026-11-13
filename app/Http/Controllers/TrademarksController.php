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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TrademarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $this->resultsPerPage($request);
        return view('trademark.index', compact('perPage'));
    }

    private function resultsPerPage(Request $request): int
    {
        $perPage = (int) $request->user()->getAttribute('trademark_results_per_page');
        return in_array($perPage, [25, 50, 100], true) ? $perPage : 50;
    }

    public function advance(Request $request)
    {
        try {
            $filters = $this->searchFilters($request);
            $perPage = (int) ($filters['per_page'] ?? $this->resultsPerPage($request));
            $user = $request->user();
            if (isset($filters['per_page']) && $user->exists && $perPage !== $this->resultsPerPage($request)) {
                $user->setAttribute('trademark_results_per_page', $perPage);
                $user->save();
            }

            $trademarks = $this->resultsQuery($filters);

            $query = $trademarks;
            $trademarks = $query->paginate($perPage);
            if ($trademarks->total() > 0 && $trademarks->currentPage() > $trademarks->lastPage()) {
                $trademarks = $query->paginate($perPage, ['*'], 'page', $trademarks->lastPage());
            }
            $trademarks->appends(array_merge($request->query(), ['per_page' => $perPage]));

            if ($request->ajax()) {
                return view('trademark._results', compact('trademarks'));
            }

            if ($trademarks->isEmpty()) {
                return view('trademark.index', compact('trademarks'))
                    ->with('info', 'No records were found with the selected filters.');
            }

            return view('trademark.index', compact('trademarks'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->expectsJson()) return response()->json(['errors' => $e->errors()], 422);
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

    private function searchFilters(Request $request): array
    {
            $filters = $request->validate([
                'sort' => ['nullable', Rule::in(array_slice(array_keys(\App\Support\ResultsColumns::definitions()), 2))],
                'direction' => ['nullable', Rule::in(['asc', 'desc'])],
                'per_page' => ['nullable', 'integer', Rule::in([25, 50, 100])],
                'page' => ['nullable', 'integer', 'min:1'],
                'specific_files' => ['nullable', 'string', 'max:4000', function ($attribute, $value, $fail) {
                    try { \App\Support\SpecificFiles::parse($value); }
                    catch (\InvalidArgumentException $error) { $fail($error->getMessage()); }
                }],
                'q'                   => ['nullable', 'string', 'max:255'],
                'our_ref'             => ['nullable', 'string', 'max:100'],
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
                'filing_from'         => ['nullable', 'date'],
                'filing_to'           => ['nullable', 'date'],
                'registration_from'   => ['nullable', 'date'],
                'registration_to'     => ['nullable', 'date'],
                'last_declaration'    => ['nullable', 'date'],
                'next_declaration'    => ['nullable', 'date'],
                'last_renewal'        => ['nullable', 'date'],
                'next_renewal'        => ['nullable', 'date'],
                'from_refs'           => ['nullable', 'integer'],
                'to_refs'             => ['nullable', 'integer'],
            ]);

            foreach ([['from_refs', 'to_refs'], ['filing_from', 'filing_to'], ['registration_from', 'registration_to'], ['last_declaration', 'next_declaration'], ['last_renewal', 'next_renewal']] as [$from, $to]) {
                if (isset($filters[$from], $filters[$to]) && $filters[$from] > $filters[$to]) {
                    throw \Illuminate\Validation\ValidationException::withMessages([$to => 'To must be greater than or equal to From.']);
                }
            }
        return $filters;
    }

    private function resultsQuery(array $filters)
    {
        $referenceNumber = DB::raw(DB::getDriverName() === 'mysql' ? 'CAST(our_ref AS SIGNED)' : 'CAST(our_ref AS INTEGER)');
            $trademarks = Trademarks::query()
                ->with([
                    'Client:id,company_name',
                    'Holder:id,company_name',
                    'AddressHolder:id,address', 'AddressContact:id,address',
                ])

                ->when(!empty($filters['our_ref']), fn ($query) =>
                    $query->where('our_ref', 'like', '%' . trim($filters['our_ref']) . '%')
                )

                ->when(trim((string) ($filters['q'] ?? '')) !== '', function ($query) use ($filters) {
                    $value = trim($filters['q']);

                    $query->where(function ($q) use ($value) {
                        $q->where('our_ref', 'like', "%{$value}%")
                            ->orWhere('client_ref', 'like', "%{$value}%")
                            ->orWhere('trademark', 'like', "%{$value}%")
                            ->orWhere('application_no', 'like', "%{$value}%")
                            ->orWhere('registration_no', 'like', "%{$value}%")
                            ->orWhere('int_registration_no', 'like', "%{$value}%")
                            ->orWhere('opposition_no', 'like', "%{$value}%")
                            ->orWhere('litigation_no', 'like', "%{$value}%")
                            ->orWhereHas('Client', function (Builder $client) use ($value) {
                                $client->where('company_name', 'like', "%{$value}%");
                            })
                            ->orWhereHas('Holder', function (Builder $holder) use ($value) {
                                $holder->where('company_name', 'like', "%{$value}%");
                            });
                    });
                })

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

                ->when(!empty($filters['origin']), function ($query) use ($filters) {
                    if (in_array($filters['origin'], ['Foreign', 'International'], true)) {
                        $query->whereIn('origin', ['Foreign', 'International', 'Extranjero', 'Internacional']);

                        return;
                    }

                    if ($filters['origin'] === 'National') {
                        $query->whereIn('origin', ['National', 'Nacional']);
                        return;
                    }

                    $query->where('origin', $filters['origin']);
                })

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

                ->when(true, function ($query) use ($filters) {
                    $status = strtolower($filters['status'] ?? 'Live');
                    if (in_array($status, ['', 'live', 'all_except_abandoned'], true)) {
                        $query->whereIn(DB::raw('LOWER(status)'), ['pending', 'registered']);
                    } elseif ($status === 'all') {
                        $query->whereIn(DB::raw('LOWER(status)'), ['pending', 'registered', 'abandoned']);
                    } else {
                        $query->whereRaw('LOWER(status) = ?', [$status]);
                    }
                })

                ->when(!empty($filters['opposition_no']), fn ($query) =>
                    $query->where('opposition_no', 'like', '%' . trim($filters['opposition_no']) . '%')
                )

                ->when(!empty($filters['litigation_no']), fn ($query) =>
                    $query->where('litigation_no', 'like', '%' . trim($filters['litigation_no']) . '%')
                )

                ->when(!empty($filters['class']), function ($query) use ($filters) {
                    $class = $filters['class'];
                    $legacyClass = ltrim($class, '0') ?: $class;

                    $query->whereIn('class', array_unique([$class, $legacyClass]));
                })

                ->when(!empty($filters['country']), fn ($query) =>
                    $query->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(country)'), array_map('mb_strtolower', array_filter([
                        $filters['country'], \App\Support\CountryCatalog::code($filters['country'], true), \App\Support\CountryCatalog::label($filters['country'], true)
                    ])))
                )

                ->when(true, function ($query) use ($filters, $referenceNumber) {
                    foreach ([
                        ['filing_date_general', 'filing_from', 'filing_to'],
                        ['registration_date', 'registration_from', 'registration_to'],
                        ['next_declaration', 'last_declaration', 'next_declaration'],
                        ['next_renewal', 'last_renewal', 'next_renewal'],
                    ] as [$column, $from, $to]) {
                        if (!empty($filters[$from])) $query->whereDate($column, '>=', $filters[$from]);
                        if (!empty($filters[$to])) $query->whereDate($column, '<=', $filters[$to]);
                    }
                    if (isset($filters['from_refs'])) $query->where($referenceNumber, '>=', $filters['from_refs']);
                    if (isset($filters['to_refs'])) $query->where($referenceNumber, '<=', $filters['to_refs']);
                    $ranges = \App\Support\SpecificFiles::parse($filters['specific_files'] ?? '');
                    if ($ranges || isset($filters['from_refs']) || isset($filters['to_refs'])) {
                        $query->whereRaw(DB::getDriverName() === 'mysql'
                            ? "our_ref REGEXP '^[0-9]+$'"
                            : "our_ref NOT GLOB '*[^0-9]*' AND our_ref <> ''");
                    }
                    if ($ranges) $query->where(function ($numbers) use ($ranges, $referenceNumber) {
                        foreach ($ranges as [$from, $to]) $numbers->orWhereBetween($referenceNumber, [$from, $to]);
                    });
                });

            $sort = $filters['sort'] ?? 'our_ref';
            $direction = $filters['direction'] ?? 'asc';
            if (in_array($sort, ['owner', 'client'], true)) {
                $model = $sort === 'owner' ? Holder::class : Clients::class;
                $foreign = $sort === 'owner' ? 'id_holder' : 'id_client';
                $table = (new $model)->getTable();
                $trademarks->orderBy($model::select('company_name')->whereColumn($table.'.id', 'trademark.'.$foreign)->limit(1), $direction);
            } elseif (in_array($sort, ['owner_address', 'client_address'], true)) {
                $model = $sort === 'owner_address' ? \App\Models\AddressHolder::class : AddressContact::class;
                $foreign = $sort === 'owner_address' ? 'address_holder' : 'id_address';
                $table = (new $model)->getTable();
                $trademarks->orderBy($model::select('address')->whereColumn($table.'.id', 'trademark.'.$foreign)->limit(1), $direction);
            } elseif ((\App\Support\ResultsColumns::definitions()[$sort]['type'] ?? '') === 'number') {
                $cast = DB::getDriverName() === 'mysql' ? 'DECIMAL(30, 6)' : 'REAL';
                $trademarks->orderByRaw("CAST(`{$sort}` AS {$cast}) {$direction}")->orderBy($sort, $direction);
            } else {
                $trademarks->orderBy(\App\Support\ResultsColumns::definitions()[$sort]['field'] ?? $sort, $direction);
            }
            $trademarks->orderBy('id');

        return $trademarks;
    }

    public function export(Request $request, \App\Services\TrademarkExport $exporter)
    {
        $data = $request->validate([
            'format' => ['required', Rule::in(['xlsx', 'csv', 'docx', 'pdf', 'template'])],
            'ids' => 'required|array|min:1|max:10000', 'ids.*' => 'required|integer|min:1|distinct',
            'template' => ['nullable', Rule::in(array_keys($exporter->templates()))],
        ]);
        if ($data['format'] === 'template' && empty($data['template'])) {
            throw \Illuminate\Validation\ValidationException::withMessages(['template' => 'Choose a stored template.']);
        }
        $filters = $this->searchFilters($request);
        $records = $this->resultsQuery($filters)->whereIn('trademark.id', $data['ids'])->get();
        abort_if($records->isEmpty(), 422, 'No records to export.');
        return $exporter->download($records, $data['format'], $data['template'] ?? null);
    }

    public function quickSearch(Request $request)
    {
        $data = $request->validate(['number' => ['required', 'string', 'max:64', 'regex:/^[0-9]+$/']]);
        $number = $data['number'];
        $labels = ['our_ref' => 'Our Reference', 'application_no' => 'Application No.', 'registration_no' => 'Registration No.'];
        $matches = Trademarks::query()->select(['id', 'trademark', 'our_ref', 'application_no', 'registration_no'])
            ->where(function ($query) use ($number) {
                $query->where('our_ref', $number)->orWhere('application_no', $number)->orWhere('registration_no', $number);
            })->orderBy('id')->get()->map(function ($record) use ($number, $labels) {
                $fields = [];
                foreach ($labels as $key => $label) {
                    if ((string) $record->{$key} === $number) $fields[] = $label;
                }
                return ['id' => $record->id, 'trademark' => $record->trademark ?: 'Trademark',
                    'our_ref' => $record->our_ref, 'application_no' => $record->application_no,
                    'registration_no' => $record->registration_no, 'matched_fields' => $fields,
                    'url' => route('show.trademarks', $record->id)];
            })->filter(fn ($record) => count($record['matched_fields']) > 0)->values();
        return response()->json(['number' => $number, 'matches' => $matches]);
    }

    public function globalSearch(Request $request)
    {
        $data = $request->validate(['q' => 'required|string|max:255']);
        $term = trim($data['q']);
        $numeric = ctype_digit($term);
        $numberFields = ['our_ref' => 'Our Reference', 'application_no' => 'Application No.', 'registration_no' => 'Registration No.',
            'int_registration_no' => "Int’l Registration No.", 'opposition_no' => 'Opposition No.', 'litigation_no' => 'Litigation No.'];
        $textFields = ['client_ref' => 'Client Reference', 'trademark' => 'Trademark'];
        $matches = Trademarks::with(['Client:id,company_name', 'Holder:id,company_name'])
            ->where(function ($query) use ($term, $numeric, $numberFields, $textFields) {
                foreach ($numberFields as $key => $label) $query->orWhere($key, $numeric ? '=' : 'like', $numeric ? $term : "%{$term}%");
                foreach ($textFields as $key => $label) $query->orWhere($key, 'like', "%{$term}%");
                $query->orWhereHas('Client', fn ($party) => $party->where('company_name', 'like', "%{$term}%"))
                    ->orWhereHas('Holder', fn ($party) => $party->where('company_name', 'like', "%{$term}%"));
            })->orderBy('id')->get()->map(function ($record) use ($term, $numeric, $numberFields, $textFields) {
                $fields = [];
                foreach ($numberFields + $textFields as $key => $label) {
                    $value = (string) $record->{$key};
                    if ($numeric && isset($numberFields[$key]) ? $value === $term : mb_stripos($value, $term) !== false) $fields[] = $label;
                }
                foreach (['Holder' => 'Owner', 'Client' => 'Client'] as $relation => $label) {
                    if (mb_stripos((string) optional($record->{$relation})->company_name, $term) !== false) $fields[] = $label;
                }
                return ['id' => $record->id, 'trademark' => $record->trademark ?: 'Trademark', 'our_ref' => $record->our_ref,
                    'application_no' => $record->application_no, 'registration_no' => $record->registration_no,
                    'matched_fields' => $fields, 'url' => route('show.trademarks', $record->id)];
            })->filter(fn ($record) => count($record['matched_fields']) > 0)->values();
        return response()->json(['query' => $term, 'matches' => $matches]);
    }

    private function trademarkRules(?int $id = null, bool $requireCoreFields = true): array
    {
        $ourRefRules = ['nullable', 'regex:/^[1-9][0-9]{0,4}$/', Rule::unique('trademark', 'our_ref')->ignore($id)];
        $dateRule = 'nullable|date_format:Y-m-d';
        $originalReference = $id ? (string) Trademarks::findOrFail($id)->client_ref : '';

        return [
            'notes'                   => 'nullable|string',
            'our_ref'                 => $ourRefRules,
            'client_ref' => ['nullable', 'string', function ($attribute, $value, $fail) use ($originalReference) {
                if ($originalReference !== '' && $value === $originalReference) return;
                if (mb_strlen($value) > 30) $fail('Client Reference must contain no more than 30 characters.');
                elseif (!preg_match('~^[\p{L}\p{N} ./()\[\]-]+$~u', $value)) $fail('Client Reference allows letters, numbers, spaces and - . / ( ) [ ].');
            }],
            'opposition_no'           => 'nullable|string|max:100',
            'filing_date_opposition'  => $dateRule,
            'litigation_no'           => 'nullable|string|max:100',
            'filing_date_litigation'  => $dateRule,
            'application_no'          => ['nullable', 'regex:/^[1-9][0-9]{0,9}$/'],
            'origin'                  => 'nullable|string|max:50',
            'registration_no'         => ['nullable', 'regex:/^[1-9][0-9]{0,9}$/'],
            'country'                 => 'nullable|string|max:150',
            'filing_date_general'     => $dateRule,
            'status'                  => 'nullable|string|max:50',
            'first_date'              => $dateRule,
            'int_registration_no'     => 'nullable|string|max:100',
            'registration_date'       => $dateRule,
            'int_registration_date'   => $dateRule,
            'int_renewal_date'        => $dateRule,
            'expiration_date'         => $dateRule,
            'contracting_organization'=> 'nullable|string|max:255',
            'publication_date'        => $dateRule,
            'opposition_deadline' => $dateRule,
            'opposition_response_date' => $dateRule,
            'closing_arguments_deadline' => $dateRule,
            'closing_arguments_date' => $dateRule,
            'first_office_action_deadline' => $dateRule,
            'second_office_action_deadline' => $dateRule,
            'office_action_response' => $dateRule,
            'additional_office_action_date' => $dateRule,
            'suspension_request_date' => $dateRule,
            'suspension_period_end_date' => $dateRule,

            'designated_countries'    => 'nullable|string|max:255',
            'last_declaration'        => $dateRule,
            'last_renewal'            => $dateRule,
            'next_declaration'        => $dateRule,
            'next_renewal'            => $dateRule,
            'trademark'               => 'nullable|string|max:250',
            'description_trademark'   => 'nullable|string',
            'type_application'        => 'nullable|string|max:100',
            'type_mark'               => 'nullable|string|max:100',
            'translation'             => 'nullable|string',
            'transliteration_trademark'=> 'nullable|string',
            'disclaimer'              => 'nullable|string',
            'class'                   => ['nullable', Rule::in(array_map(fn ($class) => str_pad($class, 2, '0', STR_PAD_LEFT), range(1, 45)))],
            'translation_good'        => 'nullable|string',
            'description_good'        => 'nullable|string',
            'priority_no'             => 'nullable|string|max:100',
            'country_office'          => 'nullable|string|max:150',
            'priority_date'           => $dateRule,

            'id_client'               => $requireCoreFields ? 'nullable|exists:clients,id' : 'nullable',
            'id_contact'              => $requireCoreFields ? 'nullable|exists:contact_clients,id' : 'nullable',
            'id_address'              => $requireCoreFields ? 'nullable|exists:adress_clients,id' : 'nullable',
            'id_holder'               => $requireCoreFields ? 'nullable|exists:holder,id' : 'nullable',
            'address_holder'          => $requireCoreFields ? 'nullable|exists:address_holder,id' : 'nullable',
            'industrial_address'      => 'nullable|string|max:255',

            'design'                  => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'remove_design'           => 'nullable|boolean',
        ];
    }

    private function fillTrademarkFromRequest(Trademarks $trademark, array $data, Request $request): void
    {
        $dateFields = [
            'filing_date_opposition',
            'filing_date_litigation',
            'filing_date_general',
            'first_date',
            'registration_date',
            'int_registration_date',
            'int_renewal_date',
            'expiration_date',
            'publication_date',
            'opposition_deadline',
            'opposition_response_date',
            'closing_arguments_deadline',
            'closing_arguments_date',
            'first_office_action_deadline',
            'second_office_action_deadline',
            'office_action_response',
            'additional_office_action_date',
            'suspension_request_date',
            'suspension_period_end_date',

            'last_declaration',
            'last_renewal',
            'next_declaration',
            'next_renewal',
            'priority_date',
        ];

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
            'int_renewal_date',
            'expiration_date',
            'contracting_organization',
            'publication_date',
            'opposition_deadline',
            'opposition_response_date',
            'closing_arguments_deadline',
            'closing_arguments_date',
            'first_office_action_deadline',
            'second_office_action_deadline',
            'office_action_response',
            'additional_office_action_date',
            'suspension_request_date',
            'suspension_period_end_date',

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
            if (!array_key_exists($field, $data)) {
                continue;
            }

            $value = $data[$field] ?? null;

            if (in_array($field, $dateFields, true)) {
                $value = $this->normalizeTrademarkDate($value);
            }

            $trademark->{$field} = $value;
        }

        if ($request->boolean('remove_design') && !$request->hasFile('design')) {
            $trademark->design = null;
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

    private function normalizeTrademarkDate($value): ?string
    {
        if (!filled($value)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
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
        try {
            $data = $request->validate($this->trademarkRules());

            $trademark = new Trademarks();
            $this->fillTrademarkFromRequest($trademark, $data, $request);
            $trademark->save();

            return redirect()
                ->route('show.trademarks', $trademark->id)
                ->with('trademark_saved', true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Trademark creation failed', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('swal_error', 'An unexpected error occurred while creating the trademark.');
        }
    }

    public function edit($id)
    {
        $trademark = Trademarks::with([
            'Client:id,company_name',
            'Holder:id,company_name',
            'ContactClient:id,name,email',
            'AddressContact:id,address,billing_address',
            'AddressHolder:id,address',
        ])->findOrFail($id);

        return view('trademark.edit', compact('trademark'));
    }

    public function show($id)
    {
        $trademark = Trademarks::with([
            'Client:id,company_name',
            'Holder:id,company_name',
            'ContactClient:id,name,email',
            'AddressContact:id,address,billing_address',
            'AddressHolder:id,address',
        ])->findOrFail($id);

        return view('trademark.show', compact('trademark'));
    }

    public function update(Request $request, $id)
    {
        try {
            $trademark = Trademarks::findOrFail($id);

            $data = $request->validate($this->trademarkRules($trademark->id, false));

            $this->fillTrademarkFromRequest($trademark, $data, $request);
            $trademark->save();

            return redirect()
                ->route('show.trademarks', $trademark->id)
                ->with('trademark_saved', true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Trademark update validation failed', [
                'trademark_id' => $id,
                'errors' => $e->errors(),
            ]);

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
