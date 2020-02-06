<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//название текущей директории
preg_match('~/[^/]+$~', getcwd(), $dirnameMatch);

$dirname = $dirnameMatch[0] . '/';


define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . $dirname);
define('HTTP_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . $dirname);

require_once 'App.php';
