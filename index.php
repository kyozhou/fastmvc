<?php
$system_time_start = microtime();

include dirname(__FILE__) . '/common/common.php';
include dirname(__FILE__) . '/common/lib/Router.php';

$router = new Router(APP_ROOT);
$router->action();

echo '<!--' . (microtime() - $system_time_start) . '-->';
