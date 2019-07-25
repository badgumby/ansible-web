<html>
<head>
  <link rel = "stylesheet" type = "text/css" href = "style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
  <body>
    <div class="placediv">
    <?php
    $dir = "inventory/";
    $files = array_diff(scandir($dir, 0), array('..','.'));
    if (count($files) < 1) {
      echo "No servers found in inventory directory. <h3>Please run the 'gather-playbook.sh' script.</h3><h3>If you have already ran the script, verify your webserver config/permissions.</h3>";
    } else {
      echo "Please select a server to view.";
    }
    ?>
    </div>
  </body>
</html>
