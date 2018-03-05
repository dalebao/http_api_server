<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 3/3/18
 * Time: 22:37
 */

namespace Application\Traits;

trait ResponseTrait
{


    public function resultResponse()
    {
        $result = !isset(self::$result[$this->method . $this->uri][$this->param_str])
            ? self::$result
            : self::$result[$this->method . $this->uri][$this->param_str];;
        $result = is_string($result) ? $result : json_encode($result);
        $this->response->end($result);
    }

    public function exceptionResponse(\Exception $e)
    {
        $result = json_encode(['msg'=>$e->getMessage(),'code'=>$e->getCode(),'line'=>$e->getLine()]);
        $this->response->status(500);
        $this->response->wirte($result);
    }

}