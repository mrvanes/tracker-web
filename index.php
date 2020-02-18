<?php
require_once('lib/config.php');
require_once('lib/database.php');
require_once('lib/authentication.php');
error_reporting(E_ALL ^ E_NOTICE);

// Initialise database
db_connect($conf['db']['server'], $conf['db']['schema'], $conf['db']['user'], $conf['db']['password']);
$messages = array();
$errors = array();

$path = rtrim($_SERVER['PATH_INFO'], '/');
if (!file_exists("pages/$path")) header('location: /error');

$page = 'pages';
$pathArr = explode('/', $path);

foreach ($pathArr as $p) {
  $page .= $p . '/';
  $initpage = $page . 'init.php';
  if (is_file($initpage)) {
    include($initpage);
  }
}

include('templates/' . $t['site'] . "/site.php");
?>
