&copy;2014 - 2020 MrVanes
<?php
if ($debug) {
  echo "<div class=debug><b>Debug pane</b><pre>";
  echo "path: $path\n";
  echo "page: $page\n";
  echo "user: $user_id\n";
  echo "name: $user_name\n";
  echo "admin: $user_admin\n";
  if (count($user_attributes)) {
    echo "attributes ";
    print_r($user_attributes);
  }
  if (count($_GET)) {
    echo "GET ";
    print_r($_GET);
  }
  if (count($_POST)) {
    echo "POST ";
    print_r($_POST);
  }
  if (count($_SESSION)) {
    echo "SESSION ";
    print_r($_SESSION);
  }
  if (count($Q_DELAY)) {
    echo "Q_DELAY ";
    print_r($Q_DELAY);
  }
  if (count($Q_ERROR)) {
    echo "Q_ERROR ";
    print_r($Q_ERROR);
  }
  echo "</pre></div>\n";
}
?>
