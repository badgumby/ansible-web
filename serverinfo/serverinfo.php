<?php

// Catch post of selected server
$serverInfo = htmlspecialchars($_POST['server']);

// Explode server info results
$serverInfo_explode = explode('|', $serverInfo);
$server = $serverInfo_explode[0];
$serverDisplay = $serverInfo_explode[1];

?>
<html>
<head>
  <link rel = "stylesheet" type = "text/css" href = "style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <title><?php echo $serverDisplay; ?> - Server Info</title>
</head>
<?php
// File used for Access Control
$filename = "inventory/$server";
$loadServer = file_get_contents($filename);
$serverDecode = json_decode($loadServer);

// Explode file into variables
$plays = $serverDecode->plays[0];
$tasks = $plays->tasks;

?>
<body class="serverInfoPage">
  <div class="sinfodiv">
<?php

foreach ($tasks as $key => $task) {
    if ($task->task->name == "gatherall : setup"){
      $hostSetup = $task->hosts->$serverDisplay;
      if ($hostSetup->unreachable == true) {
        $message = $hostSetup->msg;
      } else {
      $datetime = $hostSetup->ansible_facts->ansible_date_time;
      $hostname = $hostSetup->ansible_facts->ansible_hostname;
      $fqdn = $hostSetup->ansible_facts->ansible_fqdn;
      $distro = $hostSetup->ansible_facts->ansible_distribution;
      $distroVersion = $hostSetup->ansible_facts->ansible_distribution_version;
      $distroRelease = $hostSetup->ansible_facts->ansible_distribution_release;
      $distroVariety = $hostSetup->ansible_facts->ansible_distribution_file_variety;
      $ipv4 = $hostSetup->ansible_facts->ansible_default_ipv4;
      $ints = $hostSetup->ansible_facts->ansible_interfaces;
      $machineType = $hostSetup->ansible_facts->ansible_architecture;
      $kernel = $hostSetup->ansible_facts->ansible_kernel;
      $memFree = $hostSetup->ansible_facts->ansible_memfree_mb;
      $memTotal = $hostSetup->ansible_facts->ansible_memtotal_mb;
      $mounts = $hostSetup->ansible_facts->ansible_mounts;
      $procs = $hostSetup->ansible_facts->ansible_processor;
      $procCount = $hostSetup->ansible_facts->ansible_processor_count;
      $procCores = $hostSetup->ansible_facts->ansible_processor_cores;
      $procThreads = $hostSetup->ansible_facts->ansible_processor_threads_per_core;
      }
    } elseif ($task->task->name == "gatherall : uptime"){
      $uptime = $task->hosts->$serverDisplay->stdout;
      #$uptime = $hostGather->stdout;
    } elseif ($task->task->name == "gatherall : firewall"){
      $firewall = $task->hosts->$serverDisplay->stdout_lines;
      #$firewall = $hostFirewall->stdout_lines;
    } elseif ($task->task->name == "gatherall : packages"){
      $packages = $task->hosts->$serverDisplay->ansible_facts->packages;
      #$packages = $hostPackages->ansible_facts->packages;
    } else {
      echo "Info not found.";
    }
}
if ($message) {
  echo "<h3>$serverDisplay</h3>$message";
} else {
?>
<body class="serverInfoPage">
  <script>
    function searchFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("searchTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
</script>
  <div class="sinfodiv">
<?php echo $message;?>
<table class="infoTable">
  <tr>
    <th colspan="2"><div class="headerTitle">
      <?php echo strtoupper($hostname); ?></div>
      <font style="font-size:14;"><i>Data was collected on <?php echo "$datetime->date at $datetime->time $datetime->tz"; ?></i></font>
    </th>
  </tr>
  <tr>
    <td>
      <b>Hostname</b>
    </td>
    <td>
      <?php echo $hostname; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>FQDN</b>
    </td>
    <td>
      <?php echo $fqdn; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Distribution</b>
    </td>
    <td>
      <?php echo $distro; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Distribution Version</b>
    </td>
    <td>
      <?php echo $distroVersion; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Distribution Release</b>
    </td>
    <td>
      <?php echo $distroRelease; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Distribution Family</b>
    </td>
    <td>
      <?php echo $distroVariety; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Machine Type</b>
    </td>
    <td>
      <?php echo $machineType; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Kernel</b>
    </td>
    <td>
      <?php echo $kernel; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Uptime</b>
    </td>
    <td>
      <?php echo $uptime; ?>
    </td>
  </tr>
</table>
<br />

<br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      <div class="headerTitle">
        Network Info
      </div>
    </th>
  </tr>
  <tr>
    <td>
      <b>Default IPv4 Interface</b>
    </td>
    <td>
      <b>Interface:</b> <?php echo $ipv4->interface; ?><br />
      <b>IP Address:</b> <?php echo $ipv4->address; ?><br />
      <b>Gateway:</b> <?php echo $ipv4->gateway; ?><br />
      <b>Netmask:</b> <?php echo $ipv4->netmask; ?><br />
      <b>Type:</b> <?php echo $ipv4->type; ?><br />
      <b>MAC Address:</b> <?php echo $ipv4->macaddress; ?>
    </td>
  </tr>
    <?php
    foreach ($ints as $int) {
      $aint = "ansible_$int";
    $intDetails = $hostSetup->ansible_facts->$aint;
    if ($intDetails->active == 1) {
      $intStatus = "Active";
    } else {
      $intStatus = "Inactive";
    }
    echo "<tr><td>";
    echo "<b>$int</b>";
    echo "</td>";
    echo "<td>";
    echo "<b>Status: </b>" . $intStatus . "<br />";
    echo "<b>IP Address: </b>" . $intDetails->ipv4->address . "<br />";
    echo "<b>Netmask: </b>" . $intDetails->ipv4->netmask . "<br />";
    echo "<b>Broadcast: </b>" . $intDetails->ipv4->broadcast . "<br />";
    echo "<b>Type: </b>" . $intDetails->type . "<br />";
    echo "<b>MTU Size: </b>" . $intDetails->mtu;
    echo "</td></tr>";
  }
  ?>
</table>
<br />

<br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      <div class="headerTitle">
        Processor/Memory Info
      </div>
    </th>
  </tr>
  <tr>
    <td>
      <b>Processor Count</b>
    </td>
    <td>
      <?php
      echo "<b>Number of Processors: </b>" . $procCount . "<br />";
      echo "<b>Cores per Processor: </b>" . $procCores . "<br />";
      echo "<b>Threads per Core: </b>" . $procThreads . "<br />";
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Processor Details</b>
    </td>
    <td>
      <?php
      $counter = 0;
      $lastkey = array_key_last($procs);
      foreach ($procs as $key => $proc) {
        if ($counter == 0) {
          echo "<b>Processor: </b>" . $proc;
          echo "<br />";
          $counter++;
        } elseif ($counter == 1) {
          echo "<b>Vendor: </b>" . $proc;
          echo "<br />";
          $counter++;
        } elseif ($counter == 2 && $key == $lastkey) {
          echo "<b>Model: </b>" . $proc;
          echo "<br />";
          $counter = 0;
        } elseif ($counter == 2) {
          echo "<b>Model: </b>" . $proc;
          echo "<br /><br />";
          $counter = 0;
        }
      }
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Memory (MB)</b>
    </td>
    <td>
      <b>Free:</b> <?php echo $memFree; ?><br />
      <b>Total:</b> <?php echo $memTotal; ?>
    </td>
  </tr>
</table>
<br />
<br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      <div class="headerTitle">
        Disk Info
      </div>
    </th>
  </tr>
<?php

  foreach ($mounts as $mount){
    $total = $mount->size_total * .000001;
    $available = $mount->size_available * .000001;
    $used = $total - $available;
    ?>
    <tr>
      <td>
        <b><?php echo $mount->device; ?></b>
      </td>
      <td>
        <b>Mount:</b> <?php echo $mount->mount; ?><br />
        <b>Total Size:</b> <?php echo $total; ?> MB<br />
        <b>Used:</b> <?php echo $used; ?> MB<br />
        <b>Available:</b> <?php echo $available; ?> MB<br />
        <b>FSType:</b> <?php echo $mount->fstype; ?>
      </td>
    </tr>
  <?php
  }
?>
</table>
<br />
<br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      <div class="headerTitle">
        Firewall Rules <a href="#firewall" class="btn-main btn-color" data-toggle="collapse">Show/Hide</a>
      </div>
    </th>
  </tr>
  <tr>
    <td>
      <div id="firewall" class="collapse">
        <?php
          foreach ($firewall as $line) {
            echo "$line <br />";
          }
        ?>
        <a href="#firewall" class="btn-main btn-color" data-toggle="collapse">Show/Hide</a>
      </div>
    </td>
  </tr>
</table>
<br /><br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      <div class="headerTitle">
        Applications <a href="#apps" class="btn-main btn-color" data-toggle="collapse">Show/Hide</a>
      </div>
    </th>
  </tr>
  <tr>
    <td>
      <div id="apps" class="divCenter collapse">
        <input type="text" class="searchInput" id="searchInput" onkeyup="searchFunction()" placeholder="Search for packages.." title="Type in a package name">
        <table id='searchTable' class="searchTable">
          <tr class="header">
            <th>
              Package Name
            </th>
            <th>
              Details
            </th>
          </tr>
        <?php
          foreach ($packages as $package) {
            foreach ($package as $detail){
              echo "<tr><td>";
              echo "$detail->name";
              echo "</td><td>";
              echo "Version: $detail->version<br />";
              echo "Architecture: $detail->arch";
              echo "</td></tr>";
            }
          }
        ?>
        </table>

        <a href="#apps" class="btn-main btn-color" data-toggle="collapse">Hide</a>
      </div>
    </td>
  </tr>
</table>
<br /><br />
<?php } ?>
</div>
</body>
</html>
