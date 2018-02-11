<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/10/18
 * Time: 15:16
 */

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

