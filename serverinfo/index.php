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
<font style="text-align:center;font-size:24px;">Server List</font>
<hr></hr>
<table>
<form action="serverinfo.php" method="post" target="serverinfo" class="formNav">
  <tr>
    <td>
      <select class="select-css" name="server" id="server" size="20" required="required" onchange="this.form.submit()">
<?php

$dir = "inventory/";
$files = array_diff(scandir($dir, 0), array('..','.'));

foreach ($files as $file) {
  $fileDisplay = str_replace(".json","",$file);
?>
  <option value="<?php echo $file;?>|<?php echo $fileDisplay;?>"><?php echo strtoupper($fileDisplay);?></option>
<?php
}
 ?>
      </select>
    </td>
  </tr>
</table>
<hr></hr>
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
