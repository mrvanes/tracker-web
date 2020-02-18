<?php
$edit = ($detail == 'users');
?>
<h3>Gebruikers</h3>
<div class="admin light">
<?=($edit?"<form method='post' action='$path'>\n":"")?>
<table>
<tr>
<?=($edit?'<th></th><th></th>':'')?>
<th>id</th><th>location</th><th>name</th><?=($edit?'<th>password</th>':'')?><th>admin</th><th>viewall</th></tr>
<?php
if (is_array($users)) foreach ($users as $id => $user) {
  echo "<tr" . ($ud==$id?" class=ud":"") . ">";
  echo ($edit?"<td><a href=\"?rm=$id\"><img src=\"/style/trashcan.png\" align=center></a></td>":"");
  echo ($edit?"<td><a href=\"?ud=$id\"><img src=\"/style/edit.png\" align=center></a></td>":"");
  echo "<td>" . $id . "</td>";
  echo "<td>" . $locations[$user['location_id']]['name'] . "</td>";
  echo "<td>" . $user['name'] . "</td>";
  if ($edit) echo "<td></td>";
  echo "<td><input type=checkbox" . ($user['admin']?" checked":"") . " disabled></td>";
  echo "<td><input type=checkbox" . ($user['viewall']?" checked":"") . " disabled></td>";
  echo "</tr>\n";
}

if ($edit) {
  echo "<tr>";
  echo "<td></td><td></td>";
  echo "<td style='color: #e0e0e0'><b>" . ($ud?$ud:'') . "</b></td>";
  echo "<td><select name=location_id>" . $l_dd . "</select></td>";
  echo "<td><input name=name type=text" . ($ud?" value=\"" . $users[$ud]['name'] . "\"":"") . "></td>";
  echo "<td><input name=password type=password></td>";
  echo "<td><input name=admin type=checkbox value=1" . ($ud && $users[$ud]['admin']?" checked":"") . "></td>";
  echo "<td><input name=viewall type=checkbox value=1" . ($ud && $users[$ud]['viewall']?" checked":"") . "></td>";
  echo "</tr>\n";
  echo "<tr>";
  echo "<td></td><td></td><td></td><td colspan=4><input name=action value=Opslaan type=submit> " . ($ud?"<a href='$path'>cancel</a>":"") . "</td>";
  echo "</tr>\n";
  }
?>
</table>
<?=($ud?"<input type=hidden name=new_ud value=$ud>\n":"")?>
<?=($edit?"</form>\n":"")?>
</div>
