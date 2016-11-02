<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Helper\DBHelper;
use Auth;

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
      $newuser->db_alias = $db_name;
      $newuser->db_name = 'db_'.$db_name;
      $newuser->save();
      DBHelper::createNewDb($db_name);
      DBHelper::configureConnectionAndMigrate($db_name,$newuser);
      flash('Register sukses','info');
      return redirect('login');
    }

    public function login(){
      return view('login');
    }

    public function auth(Request $request){
      $isVerified = Auth::attempt(['email' => $request->email,'password' => $request->password]);
      if($isVerified){
        return redirect('admin-nano/index');
      } else {
        flash('Username dan password tidak cocok','danger');
        return redirect('login');
      }
    }

    public function logout(){
      Auth::logout();
      flash('Logout sukses','info');
      return redirect('login');
    }
}
