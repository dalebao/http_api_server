<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 3/3/18
 * Time: 21:57
 */

namespace Application\Services;


use Application\Traits\ResponseTrait;
use Application\Traits\RouteTrait;
use Pimple\Container;
use Swoole\Http\Request;
use Swoole\Http\Response;

class AppService
{
    use ResponseTrait,RouteTrait;
    private $response;
    private $request;
    static $result;
    static $container;
    private $method;
    private $uri;
    private $params;
    private $param_str;


    public function __construct(Request $request,Response $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->getContainer();
    }

    private function getContainer()
    {
        if (!isset(self::$container) || ! self::$container instanceof Container){
            self::$container = new Container();
        }
    }



}