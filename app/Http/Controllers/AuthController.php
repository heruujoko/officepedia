<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Helper\DBHelper;

class AuthController extends Controller
{
    public function register(){
      return view('register');
    }

    public function signup(Request $request){
      $newuser = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'db_alias' => '',
        'db_name' => ''
      ]);
      $db_name = uniqid();
      $newuser->db_alias = 'db_'.$db_name;
      $newuser->db_name = 'db_'.$db_name;
      $newuser->save();
      DBHelper::createNewDb($db_name);
      DBHelper::configureConnectionAndMigrate($db_name);
      redirect('/');
    }
}
