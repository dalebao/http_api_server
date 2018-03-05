<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/10/18
 * Time: 15:10
 */

namespace Application\App;

use Swoole\Http\Response;

class RequestHandler
{
    private static $instance;
    private $uri;
    private static $request = Response::class;
    private static $response;
    public $namespace = 'api';
    public $controller = 'index';
    public $method = 'index';

    public function __construct($request, $response)
    {
        self::$response = $response;
        self::$request = $request;
        $this->setUri(self::$request->server['request_uri']);
        $this->handleUri();
    }

    public static function setRequest($request, $response)
    {

        if (empty(self::$instance) || $request != self::$request) {
            self::$instance = new self($request, $response);
        }

        return self::$instance;
    }

    private function setUri($uri)
    {
        $this->uri = $uri;
    }

    private function handleUri()
    {
        $uri = $this->uri;
        if (isset($uri) && !empty($uri) && $uri != '/') {
            $uri = substr($uri, 1);
            list($this->namespace, $this->controller, $this->method) = explode('/', $uri);
        }
    }

    public function all()
    {
        $params_post = isset(self::$request->post) ? self::$request->post : [];
        $params_get = isset(self::$request->get) ? self::$request->get : [];
        return array_merge($params_get, $params_post);
    }

    public function input($str, $default = null)
    {

        list($method, $key) = strpos($str, '.') ? explode('.', $str) : [$str, '*'];
        if ($method != 'get' && $method != 'post') {
            self::setResponse('500', 'input wrong method:' . $method);
        }

        if (empty($key) || $key == '*') {
            return $this->all();
        } else {
            return empty(self::$request->$method[$key]) ? $default : self::$request->$method[$key];
        }
    }

    public function get($key)
    {
        return empty($key) ? self::$request->get : self::$request->get[$key];
    }

    public function post($key)
    {
        return empty($key) ? self::$request->post : self::$request->post[$key];
    }

    public static function setResponse($status, $msg)
    {
        self::$response->status($status);
        self::$response->write($msg);
    }

}


