<?php
	class   GoogleCharts
		{
			public      $newArr;
			public      $VarName;
			public      $DataArray;
			public      $options;
            
			protected   $id;
			protected   $compiler;
			protected	$chartType;
			protected	$ValueArray;
			protected	$HTML;
			
			private		$writer;
			
			const	PIE		=	'pie';
			const	SCATTER	=	'scatter';
            
			public  function __construct()
				{
					$this->options  	=   array("title"=>"Untitled");
					$this->chartType	=	'pie';
				}
			
			public	function CreateChart($settings = false)
				{
					$this->CreatePie($settings);
					return $this;
				}

			public	function CreatePie($settings = false)
				{
					if(!is_array($settings))
						return;
					$data           =   (!empty($settings['data']))? $settings['data']:false;
					$this->id       =   (!empty($settings['id']))? $settings['id']:false;
					$incr           =   (!empty($settings['incr']))? $settings['incr']:false;
					$this->VarName  =   "";
					$this->newArr   =   array();
					if($data != false && $this->id != false) {
							if(is_array($data)) {
									foreach($data as $key => $value) {
											$dvalue         =   (is_numeric($value) || strpos($value,'[') !== false)? $value:"'{$value}'";
											$key			=	(is_numeric($key))? $key:"'{$key}'";
											$this->newArr[] =   "\t\t\t\t\t[{$key}, {$dvalue}]";
										}
								}
							else
								$this->newArr[] =   $data;
						}
								
					$this->VarName  =   "DataSet{$incr}";
					if(!empty($this->newArr)) {
							$str    =   PHP_EOL."var {$this->VarName}   =   [".PHP_EOL;
							$str    .=  implode(",".PHP_EOL,$this->newArr).PHP_EOL;
							$str    .=  "\t\t\t\t]".PHP_EOL;
						}
					$this->DataArray    =   (!empty($str))? $str:false;
					return $this;
		                }
			
			protected	function MakeJSObjects($arr)
				{
					if(is_array($arr)) {			
							foreach($arr as $k => $v) {
										$return[$k]	=	$k.': '.$this->MakeJSObjects($v);
								}
						}
					else {
							$arr	=	(is_numeric($arr) || $arr === 'true' || $arr === 'false' || strpos($arr,"[") !== false)? $arr: "'$arr'";
							$return	=	(strpos($arr,'{') !== false && strpos($arr,'}') !== false)? trim($arr,"'") : $arr;
						}
					return (is_array($return))? '{ '.PHP_EOL."\t".implode(",\t".PHP_EOL."\t",$return).PHP_EOL.' }' : $return;
				}
			
			public  function ChartOptions($opts)
				{
					if(!is_array($opts))
						return $this;
					$this->options	=	"\t\tvar options =".$this->MakeJSObjects($opts).";";
					return $this;
				}

			public  function ChartInstance()
				{
					$str    =   (!empty($this->VarName))? "drawChart({$this->VarName},'{$this->id}');":"";
					$str    .=  PHP_EOL;
					return $str;
				}
	
			public  function ChartData()
				{
					$str    =   (!empty($this->DataArray))? $this->DataArray:"";
					$str    .=  PHP_EOL;
					return $str;
				}
	
			public	function jScripter()
				{
					$this->writer[]	=	$this->ChartData();
					$this->writer[]	=	$this->ChartInstance();
					return $this;
				}
			
			public  function CreateJavascript($settings = false)
				{
					$library    =   (!empty($settings['lib']))? $settings['lib']:false;
					$wrap       =   (!empty($settings['wrap']))? $settings['wrap']:false;
					if(!empty($this->writer) && empty($settings['data']))
						$settings['data']	=	$this->writer;
					else
						$settings['data']	=   (!empty($settings['data']) && is_array($settings['data']))? $settings['data']:array();
		
					if($library)
						$comp[] =   '<script type="text/javascript" src="https://www.google.com/jsapi?autoload={\'modules\':[{\'name\':\'visualization\',\'version\':\'1.1\',\'packages\':[\'corechart\']}]}"></script>'.PHP_EOL;
					if($wrap)
						$comp[] =   '<script type="text/javascript">'.PHP_EOL;
						$comp[] =   '
google.load("visualization", "1", {packages:["corechart"]});
// Let the callback run a function
google.setOnLoadCallback(function() {';
					for($i = 0; $i < count($settings['data']); $i++) {
							$comp[] =   $settings['data'][$i].PHP_EOL;
						}
					$comp[] =   '
    });
// Give the function some arguments, first is data, second id
// You could do a third for the options attribute
function drawChart(ArrayElem,IdElem)
    {
        var data = google.visualization.arrayToDataTable(ArrayElem);'.PHP_EOL;
					if(!empty($this->options))
						$comp[] =   $this->options;
					$comp[] =   '
        var chart = new google.visualization.'.$this->chartType.'(document.getElementById(IdElem));
        chart.draw(data, options);
    }';
					if($wrap)
						$comp[] =   PHP_EOL.'</script>'.PHP_EOL;
					return implode("",$comp);
				}
			
			public	function ChartKind($type = 'pie')
				{
					switch($type) {
							case('scatter'):
								$this->chartType	=	'ScatterChart';
								break;
							default:
								$this->chartType	=	'PieChart';
						}
						
					return $this;
				}
			
			public	function DataTitles($array = false)
				{
					$this->ValueArray['titles']	=	(is_array($array))? "['".implode("','",$array)."']" : '['.$array.']';
					return $this;
				}
			
			public	function DataRows($array = false)
				{
					$final	=	"";
					if(is_array($array)) {
							foreach($array as $row)
								$this->ValueArray['rows'][]	=	"[".implode(",",$row)."]";
						}
					
					if(!empty($this->ValueArray['rows']))
						$final	=	$this->ValueArray['titles'].",".implode(",",$this->ValueArray['rows']);
					
					return $final;
				}
			
			public	function MakeContainer($settings = false)
				{
					$this->HTML[]	=	$this->HTMLContainer($settings);
					return $this;
				}
			
			protected	function HTMLContainer($settings = false)
				{
					$h		=	(!empty($settings['h']))? $settings['h'] : 500;
					$w		=	(!empty($settings['w']))? $settings['w'] : 500;
					$unit	=	(!empty($settings['unit']))? $settings['unit'] : 'px';
					$wrap	=	(!empty($settings['wrap']))? $settings['wrap'] : 'div';
					$title	=	(!empty($settings['title']))? $settings['title'] : false;
					
					if($title != false)
						$build[]	=	'<h3 class="nbr_'.$this->chartType.'_charts">'.htmlspecialchars($title).'</h3>';
					
					$build[]	=	PHP_EOL.'<'.$wrap.' class="nbr_'.$this->chartType.'_wrap" id="'.$this->id.'" style="width: '.$w.$unit.'; height: '.$h.$unit.';"></'.$wrap.'>';
					
					return implode(PHP_EOL,$build);
				}
			
			public	function Containers()
				{
					ob_start();
					echo implode(PHP_EOL,$this->HTML);
					$data	=	ob_get_contents();
					ob_end_clean();
					return $data;
				}
		}
?>
