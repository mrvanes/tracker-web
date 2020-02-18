<?php
function authenticated() {
  global $user_id, $user_name, $user_admin, $user_attributes;
  global $messages, $errors;

  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT user_id, name, admin, attributes FROM users WHERE user_id = $user_id";
    if (db_select($query, $users, 'user_id')) {
      $user_name = $users[$user_id]['name'];
      $user_admin = $users[$user_id]['admin'];
      $user_attributes = (array)json_decode($users[$user_id]['attributes']);
      return true;
    } else {
      $errors[] = "Er is iets mis met de gebruiker";
      return false;
    }
  } else {
    return false;
  }
}

function login() {
  global $user_id, $user_name, $user_admin, $user_attributes, $path;
  global $messages, $errors;
  
  if (isset($_POST['action']) && $_POST['action'] == 'Inloggen') {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $query = "SELECT `user_id`, `name`, `admin`, `attributes` FROM `users` WHERE name = '$user' AND password = MD5('$password')";
    if (db_select($query, $users)) {
      $user_id = $users[0]['user_id'];
      $user_name = $users[0]['name'];
      $user_admin = $users[0]['admin'];
      $user_attributes = (array)json_decode($users[0]['attributes']);
      $messages[] = "U bent ingelogd";
      $_SESSION['user_id'] = $user_id;
    } else {
      $errors[] = "U bent niet ingelogd";
    }
  } else {
    if ($path != '/login') header('location: /login');
  }
  
}

function logout() {
  global $message, $errors;
  unset($GLOBALS['user_id'], $GLOBALS['user_name'], $GLOBALS['user_admin'], $GLOBALS['user_attributes'], $_SESSION['user_id']);
  $messages[] = "U bent uitgelogd";
}

?>