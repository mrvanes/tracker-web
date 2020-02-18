<h3>Huidige Mixers voor mijn centrale</h3>
<div class="admin light">
<table>
<tr>
<th>id</th><th>name</th><th>description</th><th>remark</th></tr>
<?php
if (is_array($all_mixers)) foreach ($all_mixers as $id => $mixer) {
  echo "<tr>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $mixer['name'] . "</td>";
  echo "<td>" . $mixer['description'] . "</td>";
  echo "<td>" . $mixer['remark'] . "</td>";
  echo "</tr>\n";
}
?>
</table>
</div>
