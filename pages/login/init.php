<?php
$t['site'] = 'login';
$t['title'] = 'Login';
$t['content'] = 'login';
$t['onload'] = 'document.loginform.user.focus();';

if (!isset($_POST['name']) && isset($user_id)) header('location: /home');

?>