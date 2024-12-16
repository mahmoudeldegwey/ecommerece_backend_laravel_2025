<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {

    Cache::put('Cachekey', 'Cachevalue', 60);

    return Cache::get('Cachekey');

    Redis::hmset('user:1', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    return $name = Redis::hget('user:1', 'email'); // hgetall



    Redis::sadd('tags', 'laravel', 'php', 'redis','redis');

    return $tags = Redis::smembers('tags');

    Redis::lpush('queue', 'job1', 'job2', 'job3');
    
    return $job = Redis::rpop('queue');

    Redis::set('email', 'mahmoud@yahoo.com');

    return Redis::get('email');

    return view('welcome');
});
