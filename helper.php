<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/10/18
 * Time: 15:16
 */
use src\Tools\DataBase;

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        $config = require 'config/app.php';
        $key_arr = explode('.',$key);
        foreach ($key_arr as $config_key) {
            $config_real = $config[$config_key];
            $config = $config_real;
        }

        return $config;
    }
}

if(!function_exists('db')){
    function db($connection = null){
        if (empty($connection)){
            $connection = config(config('default'));
        }
        return new DataBase($connection);
    }
}

if (!function_exists('app')){
    function app($class_name){
        $container = new \Pimple\Container();
        if (class_exists($class_name)){
            $container[$class_name] = function ($c) use ($class_name) {
                return new $class_name;
            };
            return $container[$class_name];
            
        }else{
            throw new Exception($class_name.' 不存在',500);
        }
    }
}

