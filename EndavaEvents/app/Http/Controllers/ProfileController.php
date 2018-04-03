<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function viewProfile()
    {
        $profile = Profile::where('id','=',Auth::id())->firstOrFail();
        return view('profile.index', compact('profile'));
    }

    public function editProfile(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    public function updateProfile(Request $request, Profile $profile) {
        $profile->update($request->all());

        return redirect()->route('profile.index')
            ->with('success','Perfil actualizado con éxito');
    }
}