<?php
require('vendor/autoload.php');
use Swoole\Http\Server;

use Application\Services\AppService;

$host = '127.0.0.1';
$port = 8000;

$server = new Server($host,$port);
$server->on("start", function ($server) use ($host,$port){
    echo "Swoole http server is started at http://".$host.":".$port."\n";
});
$server->on('request',function ($request,$response){
    $app = new AppService($request,$response);
    $app->run();
});

$server->start();