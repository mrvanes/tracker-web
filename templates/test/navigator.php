<form name=myform action=post.php method=POST onsubmit='addHash(); return false;'>
<input type=hidden name=hash>
<input type=hidden name=version value='web'>
<table>
<tr><td>ID</td><td><input type=text name=id value=testdevice></td></tr>
<tr><td>Activity</td><td>
<select name=activity>
<option value='IDLE'>IDLE</option>
<option value='STATUS_A'>Heen</option>
<option value='STATUS_B'>Wachten</option>
<option value='STATUS_C'>Lossen</option>
<option value='STATUS_D'>Terug</option>
<option value='STATUS_E'>Pauze</option>
</select>
</td></tr>
<tr><td>Lat</td><td><input type=text name=lat></td></tr>
<tr><td>Lon</td><td><input type=text name=lon></td></tr>
<tr><td></td><td><a href="#" onclick="getLocation(); return false;"><img src="/style/location.png" align=center hspace=4>Huidige locatie</a></td></tr>
<tr><td>HDOP</td><td><input type=text name=hdop value=0></td></tr>
<tr><td>Speed</td><td><input type=text name=speed value=0></td></tr>
<tr><td></td><td><input type=submit name=action value=submit ></td></tr>
</table>
</form>
