<?php

$storage      = dbFetchCell("select count(*) from storage WHERE device_id = ?", array($device['device_id']));
$diskio       = dbFetchCell("select count(*) from ucd_diskio WHERE device_id = ?", array($device['device_id']));
$mempools     = dbFetchCell("select count(*) from mempools WHERE device_id = ?", array($device['device_id']));
$processor    = dbFetchCell("select count(*) from processors WHERE device_id = ?", array($device['device_id']));

$temperatures = dbFetchCell("select count(*) from sensors WHERE sensor_class='temperature' AND device_id = ?", array($device['device_id']));
$humidity     = dbFetchCell("select count(*) from sensors WHERE sensor_class='humidity' AND device_id = ?", array($device['device_id']));
$fans         = dbFetchCell("select count(*) from sensors WHERE sensor_class='fanspeed' AND device_id = ?", array($device['device_id']));
$volts        = dbFetchCell("select count(*) from sensors WHERE sensor_class='voltage' AND device_id = ?", array($device['device_id']));
$current      = dbFetchCell("select count(*) from sensors WHERE sensor_class='current' AND device_id = ?", array($device['device_id']));
$freqs        = dbFetchCell("select count(*) from sensors WHERE sensor_class='frequency' AND device_id = ?", array($device['device_id']));
$power        = dbFetchCell("select count(*) from sensors WHERE sensor_class='power' AND device_id = ?", array($device['device_id']));

unset($datas);
$datas[] = 'overview';
if ($processor) { $datas[] = 'processor'; }
if ($mempools) { $datas[] = 'mempool'; }
if ($storage) { $datas[] = 'storage'; }
if ($diskio) { $datas[] = 'diskio'; }
if ($temperatures) { $datas[] = 'temperature'; }
if ($humidity) { $datas[] = 'humidity'; }
if ($fans) { $datas[] = 'fanspeed'; }
if ($volts) { $datas[] = 'voltage'; }
if ($freqs) { $datas[] = 'frequency'; }
if ($current) { $datas[] = 'current'; }
if ($power) { $datas[] = 'power'; }

$type_text['overview'] = "Overview";
$type_text['temperature'] = "Temperature";
$type_text['humidity'] = "Humidity";
$type_text['mempool'] = "Memory";
$type_text['storage'] = "Disk Usage";
$type_text['diskio'] = "Disk I/O";
$type_text['processor'] = "Processor";
$type_text['voltage'] = "Voltage";
$type_text['fanspeed'] = "Fanspeed";
$type_text['frequency'] = "Frequency";
$type_text['current'] = "Current";
$type_text['power'] = "Power";

print_optionbar_start();

echo("<span style='font-weight: bold;'>Health</span> &#187; ");

if (!$_GET['opta']) { $_GET['opta'] = "overview"; }

unset($sep);
foreach ($datas as $type)
{
  echo($sep);

  if ($_GET['opta'] == $type)
  {
    echo('<span class="pagemenu-selected">');
  }

  echo("<a href='device/".$device['device_id']."/health/" . $type . ($_GET['optb'] ? "/" . $_GET['optb'] : ''). "/'> " . $type_text[$type] ."</a>");
  if ($_GET['opta'] == $type) { echo("</span>"); }
  $sep = " | ";
}

print_optionbar_end();

if (is_file("pages/device/health/".mres($_GET['opta']).".inc.php"))
{
   include("pages/device/health/".mres($_GET['opta']).".inc.php");
} else {
  foreach ($datas as $type)
  {
    if ($type != "overview")
    {
      $graph_title = $type_text[$type];
      $graph_type = "device_".$type;
      include("includes/print-device-graph.php");
    }
  }
}

?>
