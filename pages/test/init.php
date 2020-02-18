<?php
$t['title'] = 'TestDevice upload form';
$t['head'] = 'test';
$t['content'] = 'test';
$t['navigator'] = 'test';

$query = "SELECT `unique_id`, `time`, `lat`, `lon`, `hdop`, `speed`, `activity`, `deliverycode`, `version` FROM trace ORDER BY `time` DESC LIMIT 40 ";
db_select($query, $trace);

$query = "SELECT tr_o.`unique_id`, tr_o.`time`, tr_o.`lat`, tr_o.`lon`, tr_o.`hdop`, tr_o.`speed`, tr_o.`activity`, d.`description`, m.`name` as mname, l.`name` as lname, tr_o.`version`
FROM trace tr_o
JOIN devices d ON d.unique_id = tr_o.unique_id
JOIN mixers m ON m.mixer_id = d.mixer_id
JOIN locations l ON l.location_id = m.location_id
WHERE `time` = (
        SELECT MAX(`time`)
        FROM trace tr_i
        WHERE tr_o.unique_id = tr_i.unique_id
)
ORDER BY `time` DESC";

$query_alt = "SELECT tr_o.`unique_id`, tr_o.`time`, tr_o.`lat`, tr_o.`lon`, tr_o.`hdop`, tr_o.`speed`, tr_o.`activity`, d.`description`, m.`name` as mname, l.`name` as lname,  tr_o.`deliverycode`, tr_o.`version`
FROM trace tr_o
JOIN devices d ON d.unique_id = tr_o.unique_id
JOIN mixers m ON m.mixer_id = d.mixer_id
JOIN locations l ON l.location_id = m.location_id
INNER JOIN (
        SELECT MAX(`time`) as maxtime, unique_id
        FROM trace
        GROUP BY unique_id
) tr_i ON (tr_i.unique_id = tr_o.unique_id AND tr_o.`time` = tr_i.`maxtime`)
ORDER BY `time` DESC";

db_select($query_alt, $lastpos);

$query = "SELECT COUNT(`time`) as n FROM trace";
db_select($query, $count);

/* Select all distinct activity transitions for all devices
SELECT tr.unique_id, tr.time, tr.activity, d.description, m.name, l.name
FROM trace tr
JOIN devices d ON d.unique_id = tr.unique_id
JOIN mixers m ON m.mixer_id = d.mixer_id
JOIN locations l ON l.location_id = m.location_id
GROUP BY unique_id
UNION
SELECT a.unique_id, a.time, a.activity, d.description, m.name, l.name
FROM trace AS a
JOIN devices d ON d.unique_id = a.unique_id
JOIN mixers m ON m.mixer_id = d.mixer_id
JOIN locations l ON l.location_id = m.location_id
WHERE a.activity <> (
        SELECT b.activity
        FROM trace AS b
        WHERE a.unique_id = b.unique_id
        AND a.time > b.time
        ORDER BY b.time DESC
        LIMIT 1
)
ORDER BY time DESC

SELECT tr.*
FROM trace tr
GROUP BY unique_id
UNION
SELECT a.*
FROM trace AS a
WHERE a.activity <> (
        SELECT b.activity
        FROM trace AS b
        WHERE a.unique_id = b.unique_id
        AND a.time > b.time
        ORDER BY b.time DESC
        LIMIT 1
)
ORDER BY time ASC
*/

?>

