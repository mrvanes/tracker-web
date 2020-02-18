<h3>All Device Activities</h3>
<div class=light>
<table>
<tr>
<th>unique_id</th><th>mixer</th><th>time</th><th>activity</th><th>deliverycode</th>
</tr>
<?php
foreach ($activities as $transition) {
  echo "<tr>\n";
  echo "<td>" . $transition['unique_id'] . "</td>\n";
  echo "<td>" . $transition['name'] . "</td>\n";
  echo "<td>" . $transition['time'] . "</td>\n";
  echo "<td>" . $transition['activity'] . "</td>\n";
  echo "<td>" . $transition['deliverycode'] . "</td>\n";
  echo "</tr>\n";
}
?>
</table>
</div>
