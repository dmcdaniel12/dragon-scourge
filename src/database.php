<?php
    require 'vendor/autoload.php';

    use Illuminate\Database\Capsule\Manager as Capsule;

    $capsule = new Capsule;

    $capsule->addConnection(array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'ds',
        'username' => 'root',
        'password' => 'VLocis4ME!',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ));

    $capsule->bootEloquent();
