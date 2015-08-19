<?php
include_once(__DIR__.'/classes/class.GoogleCharts.php');
$Googlizer					=	new GoogleCharts(); 
$settings["incr"]			=	1; 
$settings['id']				=	"piechart".$settings["incr"]; 
$title						=	"My Pie Chart"; 
// The task is required or the pie chart will fail
$settings['data']['Task']	=	$title; 
$settings['data']['cond1']	=	29; 
$settings['data']['cond2']	=	35; 
$settings['data']['cond3']	=	22; 

// Create the piechart
$Googlizer->CreatePie($settings);
// Build out the js data array
$chart1_data = $Googlizer->ChartData();
// Build out the data function
$chart1_inst = $Googlizer->ChartInstance();
// This will generate the javascript
echo $Googlizer	->ChartOptions(array("title"=>$title,"legend"=>"none","is3D"=>true))
				>ChartKind(GoogleCharts::PIE)
				->CreateJavascript(array("data"=>array($chart1_data, $chart1_inst),"wrap"=>true,"lib"=>true)); 
?><html> 
<head>
<?php
?>
</head>
<body>
	<div id="<?php echo $settings['id']; ?>" style="width: 900px; height: 500px;"></div>
</body> 
</html>
