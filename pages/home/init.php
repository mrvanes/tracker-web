<?php
$t['head'] = 'home';
$t['content'] = 'home';
$t['navigator'] = 'home';

$t['title'] = 'Home';

$viewall = ($user_attributes['viewall']?1:0);
$t['onload'] = "initmap($user_id,$viewall);";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $activity = $_GET['a'];
  $query = "UPDATE devices SET d_activity = '$activity' WHERE mixer_id = $id";
  if (!db_exec($query)) $_SESSION['errors'][] = "Er is iets misgegaan";
  else $_SESSION['messages'][] = "Update verzonden. Zodra telefoon locatie doorgeeft, wordt status overgenomen";
  header("location: $path");
}

  
  
?>