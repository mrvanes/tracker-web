<h1><a href="/"><img src="/style/tracker.png" align="top"></a> <?=$t['title']?></h1>
<div class=menu>
  <ul>
  <?php if ($user_id) foreach($all_pages as $link => $page) if ($page['rights'] <= $user_admin) echo "<li><a href=\"$link\">" . $page['title']  . "</a></li>\n"; ?>
  </ul>
</div>
<div class=login><?=($user_name?"<b>$user_name</b> | <a href=\"/logout\">logout</a>":"<a href=\"/login\">login</a>")?></div>
<div style='clear: both'></div>
<?php
if (count($errors)) {
  echo "<div class='errors'>\n";
  foreach ($errors as $error) echo $error . "<br />\n";
  echo "</div>\n";
}
if (count($messages)) {
  echo "<div class='messages'>\n";
  foreach ($messages as $message) echo $message . "<br />\n";
  echo "</div>\n";
}
?>
