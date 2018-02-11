<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/11/18
 * Time: 19:20
 */

namespace src\Controllers;

use Illuminate\Database\Capsule\Manager as Capsule;

class BaseController
{

    protected static $database;

    public function __construct()
    {
        self::$database = new Capsule();

        self::$database->addConnection(config('database'));

        self::$database->setAsGlobal();

    }


}