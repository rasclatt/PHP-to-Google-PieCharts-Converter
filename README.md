# PHP to Google Charts Converter
> Create Google Pie Charts using php. This class will build the basic chart for you.

**To use this library, apply to your page like the example below:**

````php
<?php
include_once(__DIR__.'/classes/class.nUberJTools.php');
// Here is just some misc. data from database (or manually created array)
$result	=	array(
    0 => array(
            'id' => 1,
            'lesson' => 'Community Health Care',
            'lesson_activity' => 'CHC.001',
            'count(<50%)' => 7,
            'count(Between 50-60%)' => 4,
            'count(>60%)' => 9),
    1 => array(
            'id' => 2,
            'lesson' => 'Community Health Care',
            'lesson_activity' => 'CHC.002',
            'count(<50%)' => 32,
            'count(Between 50-60%)' => 11,
            'count(>60%)' => 65),
    2 => array(
            'id' => 3,
            'lesson' => 'Community Health Care',
            'lesson_activity' => 'CHC.003',
            'count(<50%)' => 44,
            'count(Between 50-60%)' => 12,
            'count(>60%)' => 76));

// Initialize the GoogleCharts class
$Googlizer  =	nUberJTools::GoogleCharts();
// Just add a general title
$title      =	"My Trend Chart";
// Set options in general
$options['legend']	=	'none';
$options['is3D']	=	'true';
foreach($result	as $i=> $row) {	
		// The incr setting allows for unique identifier when making multiple charts
		$settings["incr"]	=	$i;
		// Create a holder name for the javascript function
		$settings['id'] 	=	"trend".$settings["incr"];
		// Create a title
		$settings['title'] 	=	"PieChart ".$i;
		// Assign data for js function to use
		$settings['data']	=	array(
										// Pie Chart needs a title row
										"Title"=>$settings['title'],
										// String required for key which shows as the
										// title for the pie slice
										"cond1"=>$row['count(<50%)'],
										"cond2"=>$row['count(Between 50-60%)'],
										"cond3"=>$row['count(>60%)']
									);
		// Returns the assembled js data arrays and the js function that displays chart
		// Create the piechart
		$Googlizer	->CreateChart($settings)
					// This assembles the javascript data arrays and functions that create the charts
					->jScripter()
					// Build the html placeholders
					->MakeContainer(array("w"=>500,"h"=>500,"unit"=>"px","wrap"=>"div"));
	}
// This applies the javascript options
echo $Googlizer	->ChartOptions($options)
				// This sets the kind of chart to display
				->ChartKind(GoogleCharts::PIE) 
				// This writes everything to the page using the assemple data arrays and functions from the loop.
				// The wrap option will write "<script>"
				->CreateJavascript(array("wrap"=>true,"lib"=>true)); 
?> 
<html> 
<body> 
<?php echo $Googlizer->Containers(); ?>
</body> 
</html>
````

**The above will generate something similar to:**

````html
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
// Let the callback run a function
google.setOnLoadCallback(function() {
var DataSet   =   [
			['Title', 'PieChart 0'],
			['cond1', 7],
			['cond2', 4],
			['cond3', 9]
		]
drawChart(DataSet,'trend0');

var DataSet1   =   [
			['Title', 'PieChart 1'],
			['cond1', 32],
			['cond2', 11],
			['cond3', 65]
		]

drawChart(DataSet1,'trend1');

var DataSet2   =   [
			['Title', 'PieChart 2'],
			['cond1', 44],
			['cond2', 12],
			['cond3', 76]
		]

drawChart(DataSet2,'trend2');

    });
// Give the function some arguments, first is data, second id
// You could do a third for the options attribute
function drawChart(ArrayElem,IdElem)
    {
        var data = google.visualization.arrayToDataTable(ArrayElem);
		var options ={ 
	legend: 'none',	
	is3D: true
 };
        var chart = new google.visualization.PieChart(document.getElementById(IdElem));
        chart.draw(data, options);
    }
</script>
<html> 
<body> 
<div class="nbr_pie_wrap" id="trend0" style="width: 500px; height: 500px;"></div>
<div class="nbr_pie_wrap" id="trend1" style="width: 500px; height: 500px;"></div>
<div class="nbr_pie_wrap" id="trend2" style="width: 500px; height: 500px;"></div></body> 
</html>
````
