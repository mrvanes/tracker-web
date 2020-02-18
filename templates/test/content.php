<h3>Last Mixer positions</h3>
<div class=light>
<table>
<tr>
<th>unique_id</th><th>time</th><th>lat</th><th>lon</th><th>hdop</th><th>speed</th><th>activity</th><th>telefoon</th><th>mixer</th><th>location</th><th>deliverycode</th><th>version</th>
</tr>
<?php
foreach ($lastpos as $record) {
  echo "<tr>\n";
  echo "<td>" . $record['unique_id'] . "</td>\n";
  echo "<td>" . $record['time'] . "</td>\n";
  echo "<td>" . $record['lat'] . "</td>\n";
  echo "<td>" . $record['lon'] . "</td>\n";
  echo "<td>" . $record['hdop'] . "</td>\n";
  echo "<td>" . $record['speed'] . "</td>\n";
  echo "<td>" . $record['activity'] . "</td>\n";
  echo "<td>" . $record['description'] . "</td>\n";
  echo "<td>" . $record['mname'] . "</td>\n";
  echo "<td>" . $record['lname'] . "</td>\n";
  echo "<td>" . $record['deliverycode'] . "</td>\n";
  echo "<td>" . $record['version'] . "</td>\n";
  echo "</tr>\n";
}
?>
</table>
</div>
<h3>Last 40 events (<?=$count[0]['n']?>)</h3> <a href="<?=$path."/activity"?>">Activity log</a>
<div class=light>
<table>
<tr>
<th>unique_id</th><th>time</th><th>lat</th><th>lon</th><th>hdop</th><th>speed</th><th>activity</th><th>deliverycode</th><th>version</th>
</tr>
<?php
foreach ($trace as $record) {
  echo "<tr>\n";
  echo "<td>" . $record['unique_id'] . "</td>\n";
  echo "<td>" . $record['time'] . "</td>\n";
  echo "<td>" . $record['lat'] . "</td>\n";
  echo "<td>" . $record['lon'] . "</td>\n";
  echo "<td>" . $record['hdop'] . "</td>\n";
  echo "<td>" . $record['speed'] . "</td>\n";
  echo "<td>" . $record['activity'] . "</td>\n";
  echo "<td>" . $record['deliverycode'] . "</td>\n";
  echo "<td>" . $record['version'] . "</td>\n";
  echo "</tr>\n";
}
?>
</table>
</div>
