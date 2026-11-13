<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function photo(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120']);
        $user = $request->user();
        $previous = $user->getAttribute('profile_photo_path');
        $photo = $request->file('photo');
        $name = (string) \Illuminate\Support\Str::uuid().'.'.$photo->extension();
        $photo->move(public_path('uploads/profile'), $name);
        $user->setAttribute('profile_photo_path', 'uploads/profile/'.$name);
        try { $user->save(); }
        catch (\Throwable $error) { @unlink(public_path('uploads/profile/'.$name)); throw $error; }
        $this->deletePhotoFile($previous);
        return redirect()->route('account.profile')->with('account_saved', true);
    }

    public function removePhoto(Request $request)
    {
        $user = $request->user();
        $previous = $user->getAttribute('profile_photo_path');
        $user->setAttribute('profile_photo_path', null);
        $user->save();
        $this->deletePhotoFile($previous);
        return redirect()->route('account.profile')->with('account_saved', true);
    }

    private function deletePhotoFile(?string $path): void
    {
        if ($path && preg_match('~^uploads/profile/[a-f0-9-]+\.(jpg|jpeg|png|webp)$~i', $path)) @unlink(public_path($path));
    }

    public function show(Request $request)
    {
        return view('account.profile', ['account' => $request->user(), 'editing' => false]);
    }

    public function edit(Request $request)
    {
        return view('account.profile', ['account' => $request->user(), 'editing' => true]);
    }

    public function results(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|array|max:20', 'order.*' => 'required|string|distinct',
            'visible' => 'present|array|max:20', 'visible.*' => 'required|string|distinct',
            'widths' => 'required|array|max:20', 'widths.*' => 'integer|min:36|max:800',
        ]);
        $preferences = \App\Support\ResultsColumns::normalize($data);
        $request->user()->setAttribute('results_columns', $preferences);
        $request->user()->save();
        return response()->json($preferences);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            'profile_photo_x' => 'sometimes|integer|min:0|max:100',
            'profile_photo_y' => 'sometimes|integer|min:0|max:100',
            'profile_photo_zoom' => 'sometimes|numeric|min:1|max:3',
            'locale' => ['required', Rule::in(['en', 'es'])],
        ]);
        $request->user()->update(['name' => $data['name'], 'email' => $data['email']]);
        foreach (['profile_photo_x', 'profile_photo_y', 'profile_photo_zoom'] as $field) {
            if (isset($data[$field])) $request->user()->setAttribute($field, $data[$field]);
        }
        $request->user()->setAttribute('preferred_locale', $data['locale'])->save();
        $request->session()->put('locale', $data['locale']);
        return redirect()->route('account.settings')->with('account_saved', true);
    }
}
