<html>
<head>
  <link rel="stylesheet" href="/style/default.css" />
  <script src="/lib/tracker.js"></script>
  <?php include("templates/" . $t['head'] . "/head.php")?>
</head>
<body<?=($t['onload']?" onload=" . $t['onload']:"")?>>
<table class=wrapper>
<tr>
  <td class=header><?php include("templates/" . $t['header'] . "/header.php")?></td>
</tr>
<tr>
  <td class=content><?php include("templates/" . $t['content'] . "/content.php")?></td>
</tr>
<tr>
  <td class=footer style='vertical-align: middle;'><?php include("templates/" . $t['footer']  . "/footer.php")?></td>
</tr>
</table>
</body>
</hmtl>



