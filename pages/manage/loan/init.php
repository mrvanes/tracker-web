<?php
$t['title'] = "Mixers Uitlenen";
$t['navigator'] = "manage";
$t['content'] = "manage/loan";

if (isset($_GET['l'])) $l = $_GET['l'];
if (isset($_POST['action'])) $action = $_POST['action']; else $action = "";

if (isset($_GET['r'])) {
  $r = $_GET['r'];
  $query = "DELETE FROM loans WHERE mixer_id = $r";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
}

if ($action == 'Uitlenen') {
  $mixer_id = $_POST['mixer_id'];
  $location_id = $_POST['location_id'];
  $remark = $_POST['remark'];
  
  $query = "INSERT INTO loans (mixer_id, location_id, remark) VALUES ($mixer_id, $location_id, '$remark')";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
}

$query = "SELECT m.mixer_id, m.name, u.location_id, l.location_id, m.description
FROM mixers m
JOIN users u ON u.location_id = m.location_id
LEFT JOIN loans l ON l.mixer_id = m.mixer_id
WHERE u.user_id = $user_id
AND (l.location_id IS NULL OR  m.location_id = l.location_id)";
db_select($query, $my_mixers, 'mixer_id');

$query = "SELECT m.mixer_id, m.name, m.description, l.name as l_name, lns.remark
FROM loans lns
JOIN users u ON lns.location_id != u.location_id
JOIN mixers m ON lns.mixer_id = m.mixer_id
JOIN locations l ON lns.location_id = l.location_id
WHERE m.location_id = u.location_id AND u.user_id = $user_id";
db_select($query, $loaned_mixers, 'mixer_id');

$query = "SELECT l.location_id, l.name
FROM locations l
JOIN users u ON l.location_id != u.location_id
WHERE u.user_id = $user_id";
db_select($query, $locations, 'location_id');

$l_dd = "";
foreach($locations as $id => $location) {
  $l_dd .= "<option value=" . $id . ">" . $location['name'] . "</option>";
}



?>