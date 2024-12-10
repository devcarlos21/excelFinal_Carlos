<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function getUsers(){
        $res = User::all();
        return response()->json($res);//Select * From users;
    }

    public function User($id){
        $res = User::find($id);
        return response()->json($res);//Select * From users;
    }

    public function insertUser(Request $request){
        $user = new User();
        $user->name = $request->nombre;
        $user->email = $request->correo;
        $user->password = $request->password;
        $user->save();
        return response()->json($user);//Select * From users;
    }

}
