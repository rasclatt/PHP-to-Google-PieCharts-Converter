<?php
include_once(__DIR__.'/classes/class.nUberJTools.php');
		
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

$Googlizer  =	nUberJTools::GoogleCharts();
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
