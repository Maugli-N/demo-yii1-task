<?php

// Точка входа Yii1 приложения.
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

$yii = __DIR__ . '/framework/yii.php';
$config = __DIR__ . '/protected/config/main.php';

require_once $yii;
Yii::createWebApplication($config)->run();
