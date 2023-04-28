<?php
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'pgsql',
    'host'      => DB_HOST,
    'database'  => 'onlinechat',
    'username'  => 'ivan',
    'password'  => 'admin',
    'port'      => 5432,
]);

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

$capsule->setAsGlobal();

$capsule->bootEloquent();