<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function show($id)
    {
        $user = User::find($id);
        $params = [
            'user' => $user,
        ];
        return view('user.show', $params);
    }
}
