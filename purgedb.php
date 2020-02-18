<?php
require_once('lib/config.php');
require_once('lib/database.php');

// Initialise database
db_connect($conf['db']['server'], $conf['db']['schema'], $conf['db']['user'], $conf['db']['password']);

$purge = date("Y-m-d", strtotime("-" . $conf['db']['purge'] . "days"));
$query = "DELETE FROM `trace` WHERE `time` < '$purge'";
//echo $query;
db_exec($query);


?>