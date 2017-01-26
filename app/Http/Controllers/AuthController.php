<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Helper\DBHelper;
use Auth;
use App\Helper\JWTHelper;
use Cookie;

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
        'db_name' => '',
        'defaultbranch' => 1
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
        $user = User::where('email',$request->email)->firstOrFail();
        $token = JWTHelper::encodeUser($user);
        return redirect('admin-nano/index')->withCookie('token_id',$token,null,null,null,false,false);
      } else {
        flash('Username dan password tidak cocok','danger');
        return redirect('login');
      }
    }

    public function logout(){
      Auth::logout();
      flash('Logout sukses','info');
      return redirect('login')->withCookie(Cookie::forget('token_id'));
    }
}
