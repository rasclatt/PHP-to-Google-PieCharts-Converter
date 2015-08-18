# PHPtoGooglePieCharts
> Create Google Pie Charts using php. This class will build the basic chart for you.

**To use this library, apply to your page like the example below:**

````php
<?php
include_once(__DIR__'/classes/class.GoogleCharts.php');
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
php````

**The above will generate something similar to:**

````php
<html> 
<head>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
// Let the callback run a function
google.setOnLoadCallback(function() {
var DataSet1   =   [
					['Task', 'CHC.001'],
					['cond1', 7],
					['cond2', 4],
					['cond3', 9]
				]


drawChart(DataSet1,'piechart1');


    });

// Give the function some arguments, first is data, second id
// You could do a third for the options attribute
function drawChart(ArrayElem,IdElem)
    {
        var data = google.visualization.arrayToDataTable(ArrayElem);
		var options = {
			title: 'CHC.001',
			legend: 'none',
			is3D: '1'
		};


        var chart = new google.visualization.PieChart(document.getElementById(IdElem));

        chart.draw(data, options);
    }
</script>
</head>
<body>
	<div id="piechart1" style="width: 900px; height: 500px;"></div>
</body> 
</html>
php````
