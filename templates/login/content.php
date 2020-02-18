<?php if (!isset($user_id)) { ?>
<div class='light'>
<form method='post' name='loginform'>
<table>
<tr><td>Gebruiker:</td><td><input type='text' name='user'></td></tr>
<tr><td>Wachtwoord:</td><td><input type='password' name='password'></td></tr>
<tr><td></td><td><input type='submit' name='action' value='Inloggen'></td></tr>
</table>
</div>
<?php } ?>
