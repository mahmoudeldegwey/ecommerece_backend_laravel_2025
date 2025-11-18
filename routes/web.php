<?php
//define('STDIN',fopen("php://stdin","r"));

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use danog\MadelineProto\Tools;
//use App\Http\Services\TelegramService;

Route::get('/test-tele', function () {

$settings = (new \danog\MadelineProto\Settings\AppInfo)
    ->setApiId(13315706)
    ->setApiHash('531d7dd9fc7a42990eb60148ee358cb2');


$MadelineProto = new \danog\MadelineProto\API(storage_path('session.madeline'),$settings);

if ($MadelineProto->getAuthorization()) {
    //return $MadelineProto->getSelf();
     //return $Updates = $MadelineProto->channels->createChannel( title: 'MahmoudChannel', about: 'MahmoudChannel');
     return $MadelineProto->sendMessage(peer: '-1002229651670', message: "hello");

    echo "yes";
}else{
    $MadelineProto->phoneLogin('+0201149147551');
$MadelineProto->completePhoneLogin('73806');
echo "no";
exit();
}

});


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
