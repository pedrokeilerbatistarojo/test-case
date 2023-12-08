<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Get data token information
 * @param $authorizationHeader
 * @return mixed
 */
function getDataTokenByAuthorizationHeader($authorizationHeader){
    $key = Services::getSecretKey();
    $token = substr($authorizationHeader, 7);
    $tokenData = JWT::decode($token, new Key($key, 'HS256'));
    return $tokenData->data;
}