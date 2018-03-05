<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/11/18
 * Time: 20:26
 */

namespace Application\Tools;

use Illuminate\Database\Capsule\Manager as Capsule;

class DataBase extends Capsule
{

    public function __construct($connection)
    {
        parent::__construct();

        $this->addConnection($connection);

        $this->setAsGlobal();

        return $this;
    }

}