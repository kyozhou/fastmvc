<?php
require_once dirname(__FILE__).'/env.php';
require_once dirname(__FILE__).'/config/'.ENVIRONMENT.'.php';
header("Content-type:text/html;charset=utf-8");
include_once APP_ROOT . '/common/lib/Loader.php';
