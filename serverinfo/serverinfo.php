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
  <title><?php echo $serverDisplay; ?> - Server Info</title>
</head>
<?php
// File used for Access Control
$filename = "inventory/$server";
$loadServer = file_get_contents($filename);
$serverDecode = json_decode($loadServer);

// Explode file into variables
$datetime = $serverDecode->ansible_facts->ansible_date_time;
$hostname = $serverDecode->ansible_facts->ansible_hostname;
$fqdn = $serverDecode->ansible_facts->ansible_fqdn;
$distro = $serverDecode->ansible_facts->ansible_distribution;
$distroVersion = $serverDecode->ansible_facts->ansible_distribution_version;
$distroRelease = $serverDecode->ansible_facts->ansible_distribution_release;
$distroVariety = $serverDecode->ansible_facts->ansible_distribution_file_variety;
$ipv4 = $serverDecode->ansible_facts->ansible_default_ipv4;
$ints = $serverDecode->ansible_facts->ansible_interfaces;
$machineType = $serverDecode->ansible_facts->ansible_architecture;
$kernel = $serverDecode->ansible_facts->ansible_kernel;
$memFree = $serverDecode->ansible_facts->ansible_memfree_mb;
$memTotal = $serverDecode->ansible_facts->ansible_memtotal_mb;
$mounts = $serverDecode->ansible_facts->ansible_mounts;
$procs = $serverDecode->ansible_facts->ansible_processor;
$procCount = $serverDecode->ansible_facts->ansible_processor_count;
$procCores = $serverDecode->ansible_facts->ansible_processor_cores;
$procThreads = $serverDecode->ansible_facts->ansible_processor_threads_per_core;

?>
<body class="serverInfoPage">
  <div class="sinfodiv">
<table class="infoTable">
  <tr>
    <th colspan="2">
      <?php echo strtoupper($hostname); ?><br />
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
</table>
<br />
<table class="infoTable">
  <tr>
    <th colspan="2">
      Network Info
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
    $intDetails = $serverDecode->ansible_facts->$aint;
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
<table class="infoTable">
  <tr>
    <th colspan="2">
      Processor/Memory Info
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
<table class="infoTable">
  <tr>
    <th colspan="2">
      Disk Info
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
</div>
</body>
</html>