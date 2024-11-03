<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Console\View\Components\Alert;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function Profile(): View
    {
        $profileData = Auth::user();
        return view('backend.profile.index', compact('profileData'));
    }

    /**
     * Update the user's profile.
     */
    public function ProfileStore(Request $request): RedirectResponse
    {
        $id = Auth::id();
        $data = User::findOrFail($id);

        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->family_name = $request->family_name;
        $data->family_name2 = $request->family_name2;
        $data->country = $request->country;
        $data->dob = $request->dob;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->age = $request->age;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();  
            $file->move(public_path('upload/admin_images'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        return redirect()->back()->with('success','Profile updated successfully');
    }

    /**
     * Display the password change form.
     */
    public function ChangePassword(): View
    {
        $profileData = Auth::user();

        return view('backend.profile.password',compact('profileData'));
    }

    /**
     * Update the user's password.
     */
    public function PasswordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            Alert::error('Error', 'Old password is incorrect');
            return redirect()->back(); 
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return redirect()->back()->with('success','Password updated successfully');
    }
}
