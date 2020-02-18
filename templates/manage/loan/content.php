<h3>Beschikbare Mixers op mijn centrale</h3>
<div class="admin light">
<table>
<tr>
<th></th><th>id</th><th>name</th><th>description</th>
</tr>
<?php
if (is_array($my_mixers)) foreach ($my_mixers as $id => $mixer) {
  echo "<tr>";
  echo "<td><a href=\"?l=$id\"><img src='/style/down.png'></a></td>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $mixer['name'] . "</td>";
  echo "<td>" . $mixer['description'] . "</td>";
  echo "</tr>\n";
}
?>
</table>
</div>

<?php if (isset($l)) { ?>
<form method='post' action='<?=$path?>'>
<input type='hidden' name='mixer_id' value=<?=$l?>>
<h3>Mixer <?=$my_mixers[$l]['name']?> uitlenen</h3>
Aan <select name='location_id'><?=$l_dd?></select> Opmerking: <input type='text' name='remark' size='40'> <input type='submit' name='action' value='Uitlenen'>
</form><br><br>
<?php } ?>

<h3>Uitgeleende Mixers</h3>
<div class="admin light">
<table>
<tr>
<th></th><th>id</th><th>name</th><th>description</th><th>location</th><th>remark</th>
</tr>
<?php
if (is_array($loaned_mixers)) foreach ($loaned_mixers as $id => $mixer) {
  echo "<tr>";
  echo "<td><a href=\"?r=$id\"><img src='/style/up.png'></a></td>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $mixer['name'] . "</td>";
  echo "<td>" . $mixer['description'] . "</td>";
  echo "<td>" . $mixer['l_name'] . "</td>";
  echo "<td>" . $mixer['remark'] . "</td>";
  echo "</tr>\n";
}
?>
</table>
</div>
