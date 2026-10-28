<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        return view('account.profile', ['account' => $request->user(), 'editing' => false]);
    }

    public function edit(Request $request)
    {
        return view('account.profile', ['account' => $request->user(), 'editing' => true]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            'locale' => ['required', Rule::in(['en', 'es'])],
        ]);
        $request->user()->update(['name' => $data['name'], 'email' => $data['email']]);
        $request->session()->put('locale', $data['locale']);
        return redirect()->route('account.settings')->with('account_saved', true);
    }
}
