<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 3/3/18
 * Time: 22:37
 */

namespace Application\Traits;


trait RouteTrait
{

    public function run()
    {
        $this->getUriAndMethod();

        $this->getParams();

        $this->getResult();

        $this->resultResponse();

    }

    private function getUriAndMethod()
    {
        $this->method = $this->request->server['request_method'];
        $this->uri = substr($this->request->server['request_uri'], 1);
    }


    private function getParams()
    {
        $method = strtolower($this->method);
        $this->params = !isset($this->request->$method) ? '' : $this->request->$method;
        $this->param_str = empty($this->params) ? '' : implode('', $this->params);
    }

    private function getResult()
    {
        if (isset(self::$result[$this->method . $this->uri][$this->param_str])) {
            return;
        }
        $this->invoke();
    }

    private function invoke()
    {
        $route_info = explode('/', $this->uri);
        $real_controller = '\\Application\\' . ucfirst($route_info[0]) . '\\' . ucfirst($route_info[1]) . 'Controller';
//        $controller_instance = new \ReflectionClass($real_controller);
//        $controller_instance = $controller_instance->newInstance();
        $message = '请求成功';
        $result = [];
        $status = 200;

        if (count($route_info) >= 3) {
            if (!class_exists($real_controller)) {
                $message = $real_controller . ' 不存在';
                $status = 500;
            } else {
                if (!isset(self::$container[$real_controller])) {
                    self::$container[$real_controller] = function ($c) use ($real_controller) {
                        return new $real_controller;
                    };
                }
            }
        }
        $method = $route_info['2'];
        if (method_exists(self::$container[$real_controller], $method)) {
            $result = self::$container[$real_controller]->$method();
        } else {
            $message = $method . ' 不存在';
            $status = 500;
        }
        self::$result[$this->method . $this->uri][$this->param_str] = [
            'message' => $message, 'status' => $status, 'result' => $result
        ];
    }
}