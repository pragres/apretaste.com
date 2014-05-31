<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="es">
	<head>
		<title>Apretaste!com | SMS</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link href="static/admin.css" rel="stylesheet"></link>
	</head>
<body>
	{= path: "?path=admin&page=message" =}
	<div id = "page">
		<h1><a href = "?path=admin&page=dashboard">Apretaste!com</a> - <a href="?path=admin&page=sms">SMS</a></h1>
		{% menu %}
		<!--{ BEGIN Hourly access }-->
		<h2>SMS by hour</h2>
		<p style="color:gray;">Number of sms sended every hour (last 20 days)</p>
		<table width="100%">
			<tr>
				<th></th>
				<?
					$totals_by_day = array();
					for ($i = 1; $i <= $lastdays; $i++) {
						echo '<th width="80" style="font-size: 10px;">' . $ah[$i]['wdia']. '</th>';
						$totals_by_day[$i] = 0;
					}					
				?>
			</tr>
			<tr>
				<th></th>
				<?
					for ($i = 1; $i <= $lastdays; $i++) {
						echo '<th width="80" style="font-size: 10px;">' . $ah[$i]['dia'] . '</th>';
					}
				?>
			</tr>
			<?
				foreach ($access_by_hour as $_key => $hour_data) {
					echo '<tr><td align="right" valing="center" style="font-size: 10px; color:gray;"><b>' . $_key . 'h</b></td>';
					foreach ($hour_data as $__key => $value) {
						
						$value = intval($value);
						$X = $value;
						
						if (isset($totals_by_day[$__key])) $totals_by_day[$__key] += $X;
						
						$bg = 'white';
						$cl = 'black';
						
						if ($value > 0)	$bg = '#c2edc6';
						if ($value >= 15) $bg = '#67d368';
						if ($value >= 30) {$bg = '#1b6923'; $cl = 'white';}
						
						if ($X==0) $X='-';
						if ($X == 0)
							echo '<td width="80" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;">&nbsp;</td>';
						else
							echo '<td width="80" align="center" style="border-left: 1px solid #eeeeee; border-top: 1px solid #eeeeee;font-size:10px;background:' . $bg . '; color: '.$cl.';"><a style="color:black;" href="?path=admin&page=hour_activity&hour='.$_key.'&date='.$ah[$__key]['date'].'"><b>' . $X .'</b></a></td>';
					}
					echo '</tr>';
				}
			?>
    		<tr>
				<td></td>
				<?
					for ($i = 1; $i <= $lastdays; $i++) {
						$x = $totals_by_day[$i];
						if ($x < 1)	$x = '-';
						echo '<th width="80" style="font-size: 10px;border-left: 1px solid #eeeeee;border-top: 1px solid #eeeeee;"><b>' . $x .'</b></th>';
					}
				?>
			</tr>
	    </table>
		<!--{ END Hourly access }-->
	</div>
</body>
</html>