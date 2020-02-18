<?php
$t['title'] = "Manager";
$t['navigator'] = "manage";
$t['content'] = "manage";

$t['subs']['loan'] = 'Uitlenen';
$t['subs']['return'] = 'Teruggeven';

$query = "SELECT m.mixer_id,
        m.location_id as home,
        l.location_id as `out`,
        m.`name`,
        m.description,
        l.remark,
        u.user_id,
        u.location_id
FROM mixers m
LEFT JOIN loans l on l.mixer_id = m.mixer_id
LEFT JOIN users u on u.location_id = m.location_id OR u.location_id = l.location_id
WHERE ((m.location_id = u.location_id AND l.location_id IS NULL) OR l.location_id = u.location_id)
AND u.user_id = $user_id;";

db_select($query, $all_mixers, 'mixer_id');

?>
