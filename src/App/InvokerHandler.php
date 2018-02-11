<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/10/18
 * Time: 16:35
 */

namespace src\App;

use Exception;
class InvokerHandler
{
    private static $instance;
    private $namespace;
    private $controller;
    private $method;
    private $res;
    private $invoke_class;
    private static $namespace_arr = ['api'];
    public function __construct($res)
    {

    }

    public static function getInstance(RequestHandler $res)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($res);
        }
        self::setParams($res);
        return self::$instance;
    }

    public static function setParams($res)
    {
        self::$instance->res = $res;
        if (in_array($res->namespace, self::$namespace_arr)){
            self::$instance->namespace = $res->namespace;
        }else{
            self::$instance->res::setResponse(500, 'namespace can not be reach');
        }

        self::$instance->controller = $res->controller;
        self::$instance->method = $res->method;
    }

    public function invoke()
    {
        $namespace = '\\src\\' . ucfirst($this->namespace);

        $controller = ucfirst($this->controller) . 'Controller';

        try {
            if (!class_exists($namespace . '\\' . $controller)) {
                throw new Exception('controller not exist', '500');
            }
        } catch (Exception $e) {
            $this->res::setResponse($e->getCode(), $e->getMessage());
        }

        try {
            $controller_instance = new \ReflectionClass($namespace . '\\' . $controller);
            $controller_instance = $controller_instance->newInstance();
            $this->invoke_class = new \ReflectionMethod($namespace . '\\' . $controller, $this->method);
            if ($this->invoke_class->isPublic() && !$this->invoke_class->isStatic()) {
                return $this->invoke_class->invoke($controller_instance,$this->res);
            } else { // 操作方法不是public类型，抛出异常
                throw new \ReflectionException();
            }
        } catch (\ReflectionException $e) {
            $this->res::setResponse($e->getCode(), $e->getMessage());
        }
    }

}