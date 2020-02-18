<?php
$t['title'] = "Admin - Centrales";
$detail = 'locations';

if (isset($_GET['ud'])) $ud = $_GET['ud'];
if (isset($_GET['rm'])) $rm = $_GET['rm'];
if (isset($_POST['new_ud'])) $new_ud = $_POST['new_ud'];
if (isset($_POST['action'])) $action = $_POST['action'];

$reread = false;

if ($action == "Opslaan") {
  $new_lat = $_POST['lat'];
  $new_lon = $_POST['lon'];
  $new_name = $_POST['name'];
  $new_description = $_POST['description'];

  if ($new_ud) {
    $query = "UPDATE locations SET lat=$new_lat, lon=$new_lon, name='$new_name', description='$new_description' WHERE location_id=$new_ud";
  } else {
    $query = "INSERT INTO locations (lat, lon, name, description) VALUES ($new_lat, $new_lon, '$new_name', '$new_description')";
  }
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($rm) {
  $query = "DELETE FROM locations WHERE location_id=$rm";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($reread) {
  unset($locations, $l);
  // Query locations
$query = "
SELECT l.location_id, l.lat, l.lon, l.name, l.description, count(u.user_id) + count(m.mixer_id) as used
FROM locations l
LEFT JOIN users u on l.location_id = u.location_id
LEFT JOIN mixers m on l.location_id = m.location_id
GROUP BY l.location_id";
  db_select($query, $locations);
  foreach($locations as $location) {
    $l[$location['location_id']] = $location;
  }
  $locations = $l;
}

?>