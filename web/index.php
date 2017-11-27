<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
            'driver'    => 'pdo_mysql',
            'host'      => '192.168.64.2',
            'dbname'    => 'silex_app',
            'user'      => 'silex_app',
            'password'  => '',
            'charset'   => 'utf8mb4',
    ),
));

$app->mount('/', require_once __DIR__.'/../app/Controller/index.php');

$app->run();
