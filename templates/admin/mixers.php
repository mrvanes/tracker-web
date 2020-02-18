<?php
$edit = ($detail == 'mixers');
?>
<h3>Mixers</h3>
<div class="admin light">
<?=($edit?"<form method='post' action='$path'>\n":"")?>
<table>
<tr>
<?=($edit?'<th></th><th></th>':'')?>
<th>id</th><th>location</th><th>name</th><th>description</th></tr>
<?php
if (is_array($mixers)) foreach ($mixers as $id => $mixer) {
  echo "<tr" . ($ud==$id?" class=ud":"") . ">";
  echo ($edit?$mixer['used']?"<td></td>":"<td><a href=\"?rm=$id\"><img src=\"/style/trashcan.png\" align=center></a></td>":"");
  echo ($edit?"<td><a href=\"?ud=$id\"><img src=\"/style/edit.png\" align=center></a></td>":"");
  echo "<td>" . $id . "</td>";
  echo "<td>" . $locations[$mixer['location_id']]['name'] . "</td>";
  echo "<td>" . $mixer['name'] . "</td>";
  echo "<td>" . $mixer['description'] . "</td>";
  echo "</tr>\n";
}

if ($edit) {
  echo "<tr>";
  echo "<td></td><td></td>";
  echo "<td style='color: #e0e0e0'><b>" . ($ud?$ud:'') . "</b></td>";
  echo "<td><select name=location_id>" . $l_dd . "</select></td>";
  echo "<td><input name=name type=text" . ($ud?" value=\"" . $mixers[$ud]['name'] . "\"":"") . "></td>";
  echo "<td><input name=description type=text" . ($ud?" value=\"" . $mixers[$ud]['description'] . "\"":"") . "></td>";
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
