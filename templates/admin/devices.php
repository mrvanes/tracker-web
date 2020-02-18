<?php
$edit = ($detail == 'devices');
?>
<h3>Telefoons</h3>
<div class="admin light">
<?=($edit?"<form method='post' action='$path'>\n":"")?>
<table>
<tr>
<?=($edit?'<th></th><th></th>':'')?>
<th>id</th><th>mixer</th><th>unique_id</th><th>description</th></tr>
<?php
if (is_array($devices)) foreach ($devices as $id => $device) {
  echo "<tr" . ($ud==$id?" class=ud":"") . ">";
  echo ($edit?"<td><a href=\"?rm=$id\"><img src=\"/style/trashcan.png\" align=center></a></td>":"");
  echo ($edit?"<td><a href=\"?ud=$id\"><img src=\"/style/edit.png\" align=center></a></td>":"");
  echo "<td>" . $id . "</td>";
  echo "<td>" . $mixers[$device['mixer_id']]['name'] . "</td>";
  echo "<td>" . $device['unique_id'] . "</td>";
  echo "<td>" . $device['description'] . "</td>";
  echo "</tr>\n";
}

if ($edit) {
  echo "<tr>";
  echo "<td></td><td></td>";
  echo "<td style='color: #e0e0e0'><b>" . ($ud?$ud:'') . "</b></td>";
  echo "<td><select name=mixer_id>" . $m_dd . "</select></td>";
  echo "<td>";
  if (!count($unique_ids)) echo "<input name=unique_id type=text>";
  else echo "<select name=unique_id>" . $u_dd . "</select>\n";
  echo "</td>\n";
  echo "<td><input name=description type=text" . ($ud?" value=\"" . $devices[$ud]['description'] . "\"":"") . "></td>";
  echo "</tr>\n";
  echo "<tr>";
  echo "<td></td><td></td><td></td><td colspan=3><input name=action value=Opslaan type=submit> " . ($ud?"<a href='$path'>cancel</a>":"") . "</td>";
  echo "</tr>\n";
  }
?>
</table>
<?=($ud?"<input type=hidden name=new_ud value=$ud>\n":"")?>
<?=($edit?"</form>\n":"")?>
</div>
