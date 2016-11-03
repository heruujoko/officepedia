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
      'iss' => url('/'),
      'exp' => strtotime(Carbon::now()->addWeeks(2))
    ];
    $jwt = JWTAuth::fromUser($user,$customClaims);
    return $jwt;
  }

}
