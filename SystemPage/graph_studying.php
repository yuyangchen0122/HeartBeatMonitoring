<?php
$connect = mysqli_connect('softenggroup2.czmkb4udcq6o.us-east-2.rds.amazonaws.com', 'yuyangchen0122', 'a123123q45', 'HealthMonitoring');
$temp=$_SESSION['username'];
$query4 = 
"SELECT HeartRate, UNIX_TIMESTAMP(CONCAT_WS(' ', Date, Time)) AS datetime
FROM HealthMonitoring.HeartData 
WHERE username='$temp' AND activity='Studying'
ORDER BY Date DESC, Time DESC
";
$result4 = mysqli_query($connect, $query4);
$rows = array();
$table = array();

$table['cols'] = array(
	array(
		'label' => 'Date Time', 
		'type' => 'datetime'
	),
	array(
		'label' => 'Heart Rate', 
		'type' => 'number'
	)
);

while($row = mysqli_fetch_array($result4))
{
	$sub_array = array();
	$datetime = explode(".", $row["datetime"]);
	$sub_array[] =  array(
		"v" => 'Date(' . $datetime[0] . '000)'
	);
	$sub_array[] =  array(
		"v" => $row["HeartRate"]
	);
	$rows[] =  array(
		"c" => $sub_array
	);
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);
?>
<html>
<head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart()
		{
			var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

			var options = {
				title:'Heartbeat Data',
				legend:{position:'bottom'},
				chartArea:{width:'95%', height:'65%'
			}
		};

		var chart = new google.visualization.LineChart(document.getElementById('line_chart4'));

		chart.draw(data, options);
	}
</script>
</head>
<body>
	<div id="line_chart4" style="width: 900px; height: 500px"></div>
</body>
</html>