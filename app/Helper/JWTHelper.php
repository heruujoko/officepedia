<?php

namespace App\Helper;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class JWTHelper {

  private static $jwt_user;

  public static function encodeUser($user){
    $customClaims = [
      'iat' => strtotime(Carbon::now()),
      'iss' => url('/')
    ];
    $jwt = JWTAuth::fromUser($user,$customClaims);
    return $jwt;
  }

}
