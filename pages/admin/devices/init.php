<?php
$t['title'] = "Admin - Telefoons";
$detail = 'devices';

if (isset($_GET['ud'])) $ud = $_GET['ud'];
if (isset($_GET['rm'])) $rm = $_GET['rm'];
if (isset($_POST['new_ud'])) $new_ud = $_POST['new_ud'];
if (isset($_POST['action'])) $action = $_POST['action'];

$reread = false;

if ($action == "Opslaan") {
  $new_mixer_id = $_POST['mixer_id'];
  $new_unique_id = $_POST['unique_id'];
  $new_description = $_POST['description'];
  
  if ($new_ud) {
    $query = "UPDATE devices SET mixer_id=$new_mixer_id, unique_id='$new_unique_id', description='$new_description' WHERE device_id=$new_ud";
  } else {
    $query = "INSERT INTO devices (mixer_id, unique_id, description) VALUES ($new_mixer_id, '$new_unique_id', '$new_description')";
  }
  
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($rm) {
  $query = "DELETE FROM devices WHERE device_id=$rm";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($reread) {
  unset($devices, $d);
  // Query users
  $query = "SELECT device_id, mixer_id, unique_id, description FROM devices";
  db_select($query, $devices);
  foreach($devices as $device) {
    $d[$device['device_id']] = $device;
  }
  $devices = $d;
}

$query = "SELECT DISTINCT m.mixer_id, m.name, d.device_id FROM mixers m
LEFT JOIN devices d ON m.mixer_id=d.mixer_id
WHERE d.device_id IS NULL" . ($ud?" OR d.device_id=$ud":"") . ";";
db_select($query, $available_mixers);
foreach($available_mixers as $mixer) {
  $m_dd .= "<option value=" . $mixer['mixer_id'] . ($mixer['mixer_id']==$devices[$ud]['mixer_id']?" selected":"") . ">" . $mixer['name'] . "</option>";
}

$query = "SELECT DISTINCT t.unique_id, d.device_id FROM trace t
LEFT JOIN devices d ON t.unique_id=d.unique_id
WHERE d.device_id IS NULL;";
db_select($query, $unique_ids);
if ($ud) $unique_ids[]['unique_id'] = $devices[$ud]['unique_id'];
foreach ($unique_ids as $unique_id) {
//  $uids[$unique_id['device_id']] = $unique_id['unique_id'];
  $u_dd .= "<option value=" . $unique_id['unique_id'] . ($unique_id['unique_id']==$devices[$ud]['unique_id']?" selected":"") . ">" . $unique_id['unique_id'] . "</option>";
}

?>