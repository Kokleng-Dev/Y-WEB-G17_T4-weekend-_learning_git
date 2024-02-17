<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class UserController extends Controller
{
    public function store(Request $r){
        $data = $r->except('_token','password');
        $data['password'] = Hash::make($r->password);
        DB::table('users')->insert($data);

        return redirect()->back()->with('success','Insert Successfully');
    }
}
