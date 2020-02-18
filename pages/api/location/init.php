<?php
if (isset($_GET['id'])) $id = mysqli_real_escape_string($db, $_GET['id']);
else $id = 0;

$query = "SELECT l.location_id, l.lat, l.lon, l.name, l.description
FROM locations l
JOIN users u ON u.location_id = l.location_id
WHERE u.user_id = $id";
db_select($query, $locations);

if (count($locations)) $answer = $locations[0];
else $answer = null;

?>