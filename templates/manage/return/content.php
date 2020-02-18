<h3>Geleende Mixers</h3>
<div class="admin light">
<table>
<tr>
<th></th><th>id</th><th>name</th><th>description</th><th>remark</th>
</tr>
<?php
if (is_array($their_mixers)) foreach ($their_mixers as $id => $mixer) {
  echo "<tr>";
  echo "<td><a href=\"?r=$id\"><img src='/style/up.png'></a></td>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $mixer['name'] . "</td>";
  echo "<td>" . $mixer['description'] . "</td>";
  echo "<td>" . $mixer['remark'] . "</td>";
  echo "</tr>\n";
}
?>
</table>
</div>
