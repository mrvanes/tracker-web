<?php
$id = 0;
$viewall = 0;
if (isset($_GET['id'])) $id = mysqli_real_escape_string($db, $_GET['id']);
if (isset($_GET['viewall'])) $viewall = $_GET['viewall'];

$query = "SELECT tr_o.unique_id, tr_o.`time`, tr_o.lat, tr_o.lon, tr_o.hdop, tr_o.activity, m.`mixer_id` as id, m.`name`
FROM trace tr_o
JOIN devices d ON d.unique_id = tr_o.unique_id
JOIN mixers m ON m.mixer_id = d.mixer_id
LEFT join loans lns on lns.mixer_id = m.mixer_id
JOIN locations l ON l.location_id = m.location_id
LEFT JOIN users u ON u.location_id = l.location_id OR u.location_id = lns.location_id
INNER JOIN (
        SELECT MAX(`time`) as maxtime, unique_id
        FROM trace
        GROUP BY unique_id
) tr_i ON (tr_i.unique_id = tr_o.unique_id AND tr_o.`time` = tr_i.`maxtime`)
WHERE ((l.location_id = u.location_id AND lns.location_id IS NULL) OR lns.location_id = u.location_id)";
if (!$viewall) $query .= " AND u.user_id = $id\n";

$query .= "GROUP BY unique_id
ORDER BY m.`name`+0 ASC
"; 

db_select($query, $positions);

$i = 1;
if (is_array($positions)) foreach($positions as $mixer) {
  // Query mixer trail
  $trail = array(0 => array(
    "lat" => $mixer['lat'],
    "lon" => $mixer['lon']
    )
  );  
  $trailquery = "SELECT lat,lon FROM trace t
    WHERE t.unique_id = '" . $mixer['unique_id'] . "' AND time >= NOW() - INTERVAL 5 MINUTE
    ORDER BY time DESC
    LIMIT 10";
  db_select($trailquery, $trail);
  $mixer['trail'] = $trail;

  //$answer[$mixer['id']] = $mixer;
  $answer[$i++] = $mixer;
}
?>
