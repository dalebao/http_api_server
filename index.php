<?php
require('vendor/autoload.php');
use Swoole\Http\Server;

use src\App\RequestHandler;
use src\App\InvokerHandler;

$host = '127.0.0.1';
$port = 8000;

$server = new Server($host,$port);
$server->on("start", function ($server) use ($host,$port){
    echo "Swoole http server is started at http://".$host.":".$port."\n";
});
$server->on('request',function ($request,$response){
    $res = RequestHandler::setRequest($request,$response);
        $result = InvokerHandler::getInstance($res)->invoke();
    $response->end(json_encode($result));

});

$server->start();