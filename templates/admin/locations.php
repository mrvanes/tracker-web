<?php
$edit = ($detail == 'locations');
?>
<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  var form = document.forms["myform"];
  form.lat.value = Math.round(position.coords.latitude*1000000)/1000000;
  form.lon.value = Math.round(position.coords.longitude*1000000)/1000000;
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation")
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
  }
}

</script>
<h3>Centrales</h3>
<div class="admin light">
<?=($edit?"<form name=myform method='post' action='$path'>\n":"")?>
<table>
<tr>
<?=($edit?'<th></th><th></th>':'')?>
<th>id</th><th>lat</th><th>lon</th><th>name</th><th>description</th>
</tr>
<?php
if (is_array($locations)) foreach ($locations as $id => $location) {
  echo "<tr" . ($ud==$id?" class=ud":"") . ">";
  echo ($edit?$location['used']?"<td></td>":"<td><a href=\"?rm=$id\"><img src=\"/style/trashcan.png\" align=center></a></td>":"");
  echo ($edit?"<td><a href=\"?ud=$id\"><img src=\"/style/edit.png\" align=center></a></td>":"");
  echo "<td>" . $id . "</td>";
  echo "<td>" . $location['lat'] . "</td>";
  echo "<td>" . $location['lon'] . "</td>";
  echo "<td>" . $location['name'] . "</td>";
  echo "<td>" . $location['description'] . "</td>";
  echo "</tr>\n";
}

if ($edit) {
  echo "<tr>";
  echo "<td></td><td></td>";
  echo "<td style='color: #e0e0e0'><b>" . ($ud?$ud:'') . "</b></td>";
  echo "<td><input name=lat type=text" . ($ud?" value='" . $locations[$ud]['lat']:"") . "'></td>";
  echo "<td><input name=lon type=text" . ($ud?" value='" . $locations[$ud]['lon']:"") . "'></td>";
  echo "<td><input name=name type=text" . ($ud?" value='" . $locations[$ud]['name']:"") . "'></td>";
  echo "<td><input name=description type=text" . ($ud?" value='" . $locations[$ud]['description']:"") . "'></td>";
  echo "</tr>\n";
  echo "<tr>";
  echo "<td></td><td></td><td></td><td colspan=4><input name=action value=Opslaan type=submit> ";
  echo "<a href=\"#\" onclick=\"getLocation(); return false;\"><img src=\"/style/location.png\" align=center hspace=4>Huidige locatie</a> ";
  echo ($ud?"<a href='$path'>cancel</a>":"") . "</td>";
  echo "</tr>\n";
  }
?>
</table>
<?=($ud?"<input type=hidden name=new_ud value=$ud>\n":"")?>
<?=($edit?"</form>\n":"")?>
</div>
