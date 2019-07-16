<html>
<head>
  <link rel = "stylesheet" type = "text/css" href = "style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <title>Server List</title>
</head>
<body>
  <table class="fullpage">
    <tr>
      <td width="20%">
        <div class="navdiv">
<h3 align="center">Server List</h3>
<table>
<form action="serverinfo.php" method="post" target="serverinfo" class="formNav">
  <tr>
    <td>
      <select class="select-css" name="server" id="server" size="10" required="required" onchange="this.form.submit()">
<?php

$dir = "inventory/";
$files = array_diff(scandir($dir, 0), array('..','.'));

foreach ($files as $file) {
  $fileDisplay = str_replace(".json","",$file);
?>
  <option value="<?php echo $file;?>|<?php echo $fileDisplay;?>"><?php echo $fileDisplay;?></option>
<?php
}
 ?>
      </select>
    </td>
  </tr>
  <!-- Comment out button as it is handled by Js
  <tr>
  <td align="center">
      <br><input type="submit" value="View Server" class="button">
    </td>
  </tr>
-->
</table>
</form>
</div>
</td>
<td width="80%">
<iframe name="serverinfo" class="iframe-css" src="placeholder.html"></iframe>
</td>
</tr>
</table>
</body>
</html>
