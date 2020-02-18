<?php
$t['navigator'] = 'admin';
$t['content'] = 'admin';
$t['title'] = "Admin";
$detail = '';

$t['subs']['locations'] = 'Centrales';
$t['subs']['users'] = 'Gebruikers';
$t['subs']['mixers'] = 'Mixers';
$t['subs']['devices'] = 'Telefoons';


// Query locations
$query = "SELECT l.location_id, l.lat, l.lon, l.name, l.description, count(u.user_id) + count(m.mixer_id) as used
FROM locations l
LEFT JOIN users u on l.location_id = u.location_id
LEFT JOIN mixers m on l.location_id = m.location_id
GROUP BY l.location_id";
db_select($query, $locations);
foreach($locations as $location) {
  $l[$location['location_id']] = $location;
}
$locations = $l;

// Query users
$query = "SELECT user_id, location_id, name, password, admin, attributes FROM users";
db_select($query, $users);
foreach($users as $user) {
  $u[$user['user_id']] = array_merge($user, (array)json_decode($user['attributes']));
}
$users = $u;

// Query mixers
$query = "SELECT m.mixer_id, m.location_id, m.name, m.description, count(d.device_id) as used
FROM mixers m
LEFT JOIN devices d on m.mixer_id = d.mixer_id
GROUP BY m.mixer_id";
db_select($query, $mixers);
foreach($mixers as $mixer) {
  $m[$mixer['mixer_id']] = $mixer;
}
$mixers = $m;

// Query devices
$query = "SELECT device_id, mixer_id, unique_id, description FROM devices";
db_select($query, $devices);
foreach($devices as $device) {
  $d[$device['device_id']] = $device;
}
$devices = $d;


?>