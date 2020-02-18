<?php
$t['title'] = "Mixers Teruggeven";
$t['navigator'] = "manage";
$t['content'] = "manage/return";

if (isset($_GET['r'])) {
  $r = $_GET['r'];
  $query = "DELETE FROM loans WHERE mixer_id = $r";
  if (!db_exec($query)) $errors[] = "Er is iets misgegaan";
  else $messages[] = "Alles ok";
}


$query = "SELECT m.mixer_id, m.name, m.description, l.remark
FROM loans l
JOIN users u ON l.location_id = u.location_id
JOIN mixers m ON l.mixer_id = m.mixer_id
WHERE u.user_id = $user_id";
db_select($query, $their_mixers, 'mixer_id');

?>