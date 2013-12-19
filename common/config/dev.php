<?php
error_reporting(E_ALL);//开发阶段使用E_ALL

define('APP_URL', 'http://loacalhost');
define('APP_ROOT', dirname(dirname(dirname(__FILE__))));

$app_db = array(
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'user'     => 'root',
    'password' => 'root',
    'name'     => 'test',
    'charset'  => 'utf8',
);

define('APP_DB', serialize($app_db));
