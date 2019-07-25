<?php
$dir = "inventory/";
$files = array_diff(scandir($dir, 0), array('..','.'));
?>
<html>
<head>
  <link rel = "stylesheet" type = "text/css" href = "style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Bangers|Roboto&display=swap" rel="stylesheet">
  <title>Server List</title>
</head>
<body>
  <div class="navdiv">
    <div class="navTitle">
      Server List (<?php echo count($files);?>)
    </div>
<form action="serverinfo.php" method="post" target="serverinfo" class="formNav">
  <select class="select-css" name="server" id="server" size="20" required="required" onchange="this.form.submit()">
<?php
foreach ($files as $file) {
  $fileDisplay = str_replace(".json","",$file);
?>
  <option value="<?php echo $file;?>|<?php echo $fileDisplay;?>"><?php echo strtoupper($fileDisplay);?></option>
<?php
}
 ?>
  </select>
</form>
</div>

  <div class="serverInfoDiv">
    <iframe name="serverinfo" class="iframe-css" src="placeholder.php"></iframe>
  </div>

</body>
</html>
