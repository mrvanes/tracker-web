<?php
$t['title'] = "Admin - Users";
$detail = 'users';

if (isset($_GET['ud'])) $ud = $_GET['ud'];
if (isset($_GET['rm'])) $rm = $_GET['rm'];
if (isset($_POST['new_ud'])) $new_ud = $_POST['new_ud'];
if (isset($_POST['action'])) $action = $_POST['action'];

$reread = false;

if ($action == "Opslaan") {
  $new_location_id = $_POST['location_id'];
  $new_name = $_POST['name'];
  $new_password  = $_POST['password'];
  $new_admin = (isset($_POST['admin'])?1:0);
  $attributes['viewall'] = (isset($_POST['viewall'])?1:0);
  $new_attributes = json_encode($attributes);
  
  if ($new_ud) {
    $query = "UPDATE users SET location_id=$new_location_id, name='$new_name'" . ($new_password?", password=md5('$new_password')":"") . ", admin=$new_admin, attributes='$new_attributes' WHERE user_id=$new_ud";
  } else {
    $query = "INSERT INTO users (location_id, name, password, admin, attributes) VALUES ($new_location_id, '$new_name', md5('$new_password'), $new_admin, '$new_attributes')";
  }
  
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($rm) {
  $query = "DELETE FROM users WHERE user_id=$rm";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
  $reread = true;
}

if ($reread) {
  unset($users, $u);
  // Query users
  $query = "SELECT user_id, location_id, name, password, admin, attributes FROM users";
  db_select($query, $users);
  foreach($users as $user) {
    $u[$user['user_id']] = array_merge($user, (array)json_decode($user['attributes']));
  }
  $users = $u;
}

foreach($locations as $location) {
  $l_dd .= "<option value=" . $location['location_id'] . ($location['location_id']==$users[$ud]['location_id']?" selected":"") . ">" . $location['name'] . "</option>";
}


?>