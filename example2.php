<?php
// These particular settings will
// create a scatter/line graph

include(__DIR__.'/classes/class.GoogleCharts.php');
$Googlizer              =	new GoogleCharts(); 
$settings["incr"]       =	1; 
$settings['id']	        =	"trend".$settings["incr"]; 
$title			=	"My Trend Chart";

$options['title']	=	$title; 
$options['legend']      =	'none'; 
$options['pointShape']	=	'diamond';
$options['colors']	=	"['#9575cd', '#33ac71', '#000']";
$options['hAxis']	=	array('title'=>"Course","minValue"=>'0',"maxValue"=>'4'); 
$options['vAxis']	=	array('title'=>"No.of.Students","minValue"=>'0',"maxValue"=>'60'); 
$options['trendlines']	=	array(
					'0'=>array("type"=>"linear","pointSize"=>2,"pointsVisible"=> "true"),
					'1'=>array("type"=>"linear","pointSize"=>3,"pointsVisible"=> "true"),
					'2'=>array("type"=>"exponential","degree"=>3,"pointSize"=>12)
				); 
// The DateTitles method will create the columns
// The DataRows will fill each of those columns with data
$settings['data']	=	$Googlizer	->DataTitles(array("Course","No.of.Students","Weeks","Extra"))
						->DataRows(
        					                array(	
        					                        array('0','56','3','22'),
        								array('1','4','23','54'),
        								array('2','64','4','23'),
        								array('3','23','15','55'),
        								array('4','432','14','88'),
        								array('5','123','21','123')
        							        )
        							);

// Create the piechart 
$Googlizer->CreatePie($settings); 

// Build out the js data array 
$chart1_data = $Googlizer->ChartData(); 

// Build out the data function 
$chart1_inst = $Googlizer->ChartInstance(); 

// This will generate the javascript 
echo $Googlizer ->ChartOptions($options) 
		->ChartKind(GoogleCharts::SCATTER) 
		->CreateJavascript(array("data"=>array($chart1_data, $chart1_inst),"wrap"=>true,"lib"=>true)); 
?><html> 
<body> 
<div id="<?php echo $settings['id']; ?>" style="width:900px; height:500px;"></div> 
</body> 
</html>
