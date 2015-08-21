include_once(CLIENT_DIR.'/classes/class.nUberJTools.php');
		
$Googlizer				=	nUberJTools::GoogleCharts();
$Googlizer				=	new GoogleCharts(); 
$settings["incr"]		=	1; 
$settings['id']			=	"trend".$settings["incr"]; 
$title					=	"My Trend Chart";

// Set up a series of options for the scatter chart
$options['title']		=	$title; 
$options['legend']      =	'none'; 
$options['pointShape']	=	'diamond';
$options['colors']		=	"['#9575cd', '#33ac71', '#000']";
// Set the ranges fo the x and y axis
$options['hAxis']		=	array('title'=>"Course","minValue"=>'0',"maxValue"=>'4'); 
$options['vAxis']		=	array('title'=>"No.of.Students","minValue"=>'0',"maxValue"=>'60');
// Creates trend lines 
$options['trendlines']	=	array
							(
								// Options for the trend lines
								0=>array("type"=>"linear","pointSize"=>2,"pointsVisible"=> "true"),
								1=>array("type"=>"linear","pointSize"=>3,"pointsVisible"=> "true"),
								2=>array("type"=>"exponential","degree"=>3,"pointSize"=>12)
							); 
// The DateTitles method will create the columns
// The DataRows will fill each of those columns with data
// The data arrays, of course, don't need to be tabbed, it's just for demostration purposes here
$settings['data']		=	$Googlizer	->DataTitles(array("Course",	"No.of.Students",	"Weeks",	"Extra"))
										->DataRows(array(
															array('0',          '56',			'3',	'22'),
															array('1',			'4','			23',	'54'),
															array('2',			'64',			'4',	'23'),
															array('3',			'23',			'15',	'55'),
															array('4',			'432',			'14',	'88'),
															array('5',			'123',			'21',	'123')
														)
													);
// Create the piechart + 
// Build out the js data array +
// Build out the data function 
$Googlizer	->CreateChart($settings)
			->jScripter()
			->MakeContainer(array("w"=>500,"h"=>500,"unit"=>"px","wrap"=>"div"));
// This will generate the javascript 
echo $Googlizer	->ChartOptions($options)
				// Create a scatter chart
				->ChartKind(GoogleCharts::SCATTER)
				// Wrap the script in <script> tags and include the google chart js library
				->CreateJavascript(array("wrap"=>true,"lib"=>true)); 
?> 
<html> 
<body>
<-- echo out the containers for the charts to populate to -->
<?php echo $Googlizer->Containers(); ?>
</body> 
</html>
