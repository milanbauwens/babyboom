<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function show(){
        $user = auth()->user();

        return view('pages.settings', [
            'user' => $user
        ]);
    }

    public function updateUser(Request $r){
        $user = auth()->user();
        $userEntity = User::find($user->id);

        $r->validate([
            "firstname" => "string|required",
            "lastname"=> "string|required",
            "email" => "required|unique:users,email,$user->id|email|max:255"
        ]);

        $userEntity->firstname = $r->firstname;
        $userEntity->lastname = $r->lastname;
        $userEntity->email = $r->email;
        $userEntity->save();

        return redirect()->route('settings')->with('status', ucfirst(__("we've updated your profile succesfully!")));
    }
}
