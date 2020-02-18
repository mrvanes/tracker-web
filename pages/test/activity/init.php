<?php
$t['title'] = 'All Device Activity';
$t['content'] = 'test/activity';
$t['navigator'] = 'test/activity';

if (isset($_POST['id'])) $id = $_POST['id'];

// SELECT DISTINCT m.mixer_id, m.name FROM trace t
// JOIN devices d on t.unique_id = d.unique_id
// JOIN mixers m on d.mixer_id = m.mixer_id

$query = "SELECT DISTINCT unique_id FROM trace";
db_select($query, $devices);

$device_dd = "<option value=\"0\">Alles</option>\n";
foreach($devices as $device) {
  $device_dd .= "<option value=\"" . $device['unique_id'] . "\"" . ($device['unique_id']==$id?"selected":"") . ">" . $device['unique_id'] . "</option>\n";
}

// SELECT m.mixer_id, m.name, m.description, g.time, g.activity FROM (
// SELECT (@uidPre != unique_id) AS newUid, (@actPre != activity) AS newAct,
//         activity, unique_id, time,
//         @actPre := activity,
//         @uidPre := unique_id
// FROM trace, (SELECT @actPre := '', @uidPre := '') AS D
// ORDER BY unique_id ASC, time ASC) AS t
// JOIN devices d on t.unique_id = d.unique_id
// JOIN mixers m on d.mixer_id = m.mixer_id
// WHERE newUid OR newAct

$query = "SELECT t.`unique_id`, t.`time`, t.`activity`, t.`deliverycode`, m.`name` FROM (
SELECT (@uidPre != `unique_id`) AS `newUid`, (@actPre != `activity`) AS `newAct`,
        `activity`, `unique_id`, `time`, `deliverycode`,
        @actPre := `activity`,
        @uidPre := `unique_id`
FROM `trace`, (SELECT @actPre := '', @uidPre := '') as `d`
ORDER BY `unique_id` ASC, `time` ASC) AS `t`
JOIN devices `d` on t.`unique_id` = d.`unique_id`
JOIN mixers `m` on d.`mixer_id` = m.`mixer_id`
WHERE (`newUid` OR `newAct`)";
if ($id) $query .= " AND t.`unique_id`='" . $_POST['id'] . "'";
$query .= " ORDER BY t.`unique_id` ASC, t.`time` DESC";

db_select($query, $activities);

?>
