<?php
// Setup default template locations
$t['site'] = 'default';
$t['head'] = 'default';
$t['header'] = 'default';
$t['navigator'] = 'default';
$t['content'] = 'default';
$t['footer'] = 'default';

// Dummy login
session_start();
if (!authenticated()) login();
if ($user_admin < $all_pages[$path]['rights']) header('location: /error');

// Lift messages and errors through page refresh via SESSION
$messages = array_merge((array)$_SESSION['messages'], (array)$messages);
$errors = array_merge((array)$_SESSION['errors'], (array)$errors);
unset($_SESSION['messages'], $_SESSION['errors']);

?>