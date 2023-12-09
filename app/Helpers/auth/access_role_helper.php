<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Get data token information
 * @param $authorizationHeader
 * @return mixed
 * @throws RedisException
 */
function getDataTokenByAuthorizationHeader($authorizationHeader){
    $redisServices = Services::getRedisServices();
    $tokenData = $redisServices->get('jwt');

    if (!empty($tokenData)){
        return $tokenData->data;
    }

    $key = Services::getSecretKey();
    $token = substr($authorizationHeader, 7);
    $tokenData = JWT::decode($token, new Key($key, 'HS256'));
    return $tokenData->data;
}