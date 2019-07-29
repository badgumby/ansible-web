<?php
$filename = htmlspecialchars($_POST['filename']);
$hostname = htmlspecialchars($_POST['hostname']);
?>
<html>
  <head>
    <title>Delete Server</title>
    <link rel = "stylesheet" type = "text/css" href = "style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="placediv">
<?php
try {
  unlink($filename);
  echo strtoupper($hostname) . " has been deleted.";
} catch (Exception $e) {
  echo "File delete failed. <br> $e <br>";
}
 ?>
 </div>
</body>
</html>
