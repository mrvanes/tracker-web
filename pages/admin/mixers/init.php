<?php
$t['title'] = "Admin - Mixers";
$detail = 'mixers';

if (isset($_GET['ud'])) $ud = $_GET['ud'];
if (isset($_GET['rm'])) $rm = $_GET['rm'];
if (isset($_POST['new_ud'])) $new_ud = $_POST['new_ud'];
if (isset($_POST['action'])) $action = $_POST['action'];

$reread = false;

if ($action == "Opslaan") {
  $new_location_id = $_POST['location_id'];
  $new_name = $_POST['name'];
  $new_description = $_POST['description'];
  
  if ($new_ud) {
    $query = "UPDATE mixers SET location_id=$new_location_id, name='$new_name', description='$new_description' WHERE mixer_id=$new_ud";
  } else {
    $query = "INSERT INTO mixers (location_id, name, description) VALUES ($new_location_id, '$new_name', '$new_description')";
  }
  
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($rm) {
  $query = "DELETE FROM mixers WHERE mixer_id=$rm";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($reread) {
  unset($mixers, $m);
  // Query users
  $query = "SELECT m.mixer_id, m.location_id, m.name, m.description, count(d.device_id) as used
FROM mixers m
LEFT JOIN devices d on m.mixer_id = d.mixer_id
GROUP BY m.mixer_id";
  db_select($query, $mixers);
  foreach($mixers as $mixer) {
    $m[$mixer['mixer_id']] = $mixer;
  }
  $mixers = $m;
}

foreach($locations as $location) {
  $l_dd .= "<option value=" . $location['location_id'] . ($location['location_id']==$mixers[$ud]['location_id']?" selected":"") . ">" . $location['name'] . "</option>";
}

?>