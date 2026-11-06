<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function task() { return view('activities.create', ['kind' => 'task']); }
    public function event() { return view('activities.create', ['kind' => 'event']); }
    public function storeTask(Request $request) { return $this->store($request, 'task'); }
    public function storeEvent(Request $request) { return $this->store($request, 'event'); }

    private function store(Request $request, string $kind)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255', 'description' => 'nullable|string',
            'starts_at' => ($kind === 'event' ? 'required' : 'nullable').'|date_format:Y-m-d\TH:i',
            'ends_at' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:starts_at',
        ]);
        DB::table('crm_activities')->insert([
            'kind' => $kind, 'title' => $data['title'], 'description' => $data['description'] ?? null,
            'starts_at' => isset($data['starts_at']) ? str_replace('T', ' ', $data['starts_at']).':00' : null,
            'ends_at' => isset($data['ends_at']) ? str_replace('T', ' ', $data['ends_at']).':00' : null,
            'created_by' => $request->user()->id, 'created_at' => now(), 'updated_at' => now(),
        ]);
        return redirect()->route($kind === 'task' ? 'tasks.create' : 'events.create')->with('activity_saved', true);
    }
}
