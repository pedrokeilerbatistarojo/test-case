<?php

namespace App\Libraries\Redis;

use Config\Services;
use Redis;
use RedisException;

class RedisService
{
    protected Redis $redis;
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Stores data in Redis with a key and a value.
     *
     * @param string $key
     * @param mixed $value
     * @param int $expiration Expiration Time en segundos (0 para no expirar)
     * @return bool|Redis
     * @throws RedisException
     */
    public function set(string $key, $value, int $expiration = 0)
    {
        $value = json_encode($value);
        return $this->redis->set($key, $value, $expiration);
    }

    /**
     * Get redis key.
     *
     * @param string $key
     * @return mixed
     * @throws RedisException
     */
    public function get(string $key)
    {
        $result = $this->redis->get($key);
        return json_decode($result);
    }

    /**
     * Delete a redis key.
     *
     * @param string $key
     * @return false|int|Redis
     * @throws RedisException
     */
    public function delete(string $key)
    {
        return $this->redis->del($key);
    }

}