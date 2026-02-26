<?php

// Точка входа Yii1 приложения.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

$yii = dirname(__DIR__) . '/framework/yii.php';
$config = dirname(__DIR__) . '/protected/config/main.php';

require_once $yii;
Yii::createWebApplication($config)->run();
