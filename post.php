<?php
header("refresh:1;url=/test" );
require_once('lib/config.php');
require_once('lib/database.php');

// Initialise database
db_connect($conf['db']['server'], $conf['db']['schema'], $conf['db']['user'], $conf['db']['password']);

$id = $_POST['id'];
$activity = $_POST['activity'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$hdop = $_POST['hdop'];
$speed = $_POST['speed'];
$version = $_POST['version'];
$hash = $_POST['hash'];

// Calculate hashcheck to prevent upload abuse
$test = $_POST;
unset($test['hash']);
unset($test['action']);
$teststring = $salt;
foreach($test as $key => $value) $teststring .= $key . '=' . $value;
$my_hash = md5($teststring);
$check = ($my_hash ===  $hash?"PASS":"FAIL");

// Force device to new activity when set from server
//$query = "SELECT unique_id, d_activity FROM devices WHERE unique_id = '$id'";
$query = "SELECT d.unique_id, d_activity, t.time, t.activity, m.deliverycode, m.name, m.location_id FROM devices d
	LEFT JOIN trace t ON d.unique_id = t.unique_id
	LEFT JOIN mixers m ON d.mixer_id = m.mixer_id
	WHERE d.unique_id = '$id'
	ORDER BY time DESC
	LIMIT 1
";
db_select($query, $d_activities, 'unique_id');
if (count($d_activities)) {
    if (isset($d_activities[$id]['d_activity'])) $activity = $d_activities[$id]['d_activity'];
    if (isset($d_activities[$id]['deliverycode'])) $deliverycode = $d_activities[$id]['deliverycode'];
    if (isset($d_activities[$id]['name'])) $truckexternalcode = $d_activities[$id]['name'];
    if (isset($d_activities[$id]['location_id'])) $location_id = $d_activities[$id]['location_id'];
    $last_activity = $d_activities[$id]['activity'];
}

// Create status array
$status['activity'] = $activity;
$status['check'] = $check;
$status['result'] = "ERROR";
$insert_ok = false;
$update_ok = false;

if ($check === "PASS") {
  $query = "INSERT INTO trace (`unique_id`, `time`, `lat`, `lon`, `hdop`, `speed`, `activity`, `deliverycode`, `version`) VALUES ('$id', NOW(), $lat, $lon, $hdop, $speed, '$activity', '$deliverycode', '$version')";
  if (db_exec($query)) $insert_ok = true;

  $query = "UPDATE devices SET d_activity = NULL WHERE unique_id = '$id'";
  if (db_exec($query)) $update_ok = true;

  if ($insert_ok && $update_ok) {
    $status['result'] = "DB_OK";
  } else {
    $status['result'] = "DB_ERROR";
  }

}

// Output JSON encoded result
echo json_encode($status);
