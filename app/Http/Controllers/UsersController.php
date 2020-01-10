<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function storeSshKey(Request $request) {
        $user = $request->user();
        $user->ssh_authorized_key = $request->ssh_authorized_key;
        $user->save();
        return redirect('/home');
    }
}
