<?php
    class   GoogleCharts
        {
            public      $newArr;
            public      $VarName;
            public      $DataArray;
            public      $options;

            protected   $id;
            protected   $compiler;

            public  function __construct()
                {
                    $this->options  =   array("title"=>"Untitled");
                }

            function CreatePie($settings = false)
                {
                    if(!is_array($settings))
                        return;

                    $data           =   (!empty($settings['data']))? $settings['data']:false;
                    $this->id       =   (!empty($settings['id']))? $settings['id']:false;
                    $incr           =   (!empty($settings['incr']))? $settings['incr']:false;

                    $this->VarName  =   "";
                    $this->newArr   =   array();

                    if($data != false && $this->id != false) {
                            foreach($data as $key => $value) {
                                    $dvalue         =   (is_numeric($value))? $value:"'{$value}'";
                                    $this->newArr[] =   "\t\t\t\t\t['{$key}', {$dvalue}]";
                                }
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

            public  function ChartData()
                {
                    $str    =   (!empty($this->DataArray))? $this->DataArray:"";
                    $str    .=  PHP_EOL;

                    return $str;
                }

            public  function ChartOptions($opts)
                {
                    if(!is_array($opts))
                        return $this;

                    $this->options  =   array();

                    foreach($opts as $key => $val) {
                            $this->options[]    =   $key.": '".$val."'";
                        }

                    if(!empty($this->options)) {
                        $this->options  =   "\t\tvar options = {".PHP_EOL."\t\t\t".implode(",".PHP_EOL."\t\t\t",$this->options).PHP_EOL."\t\t};".PHP_EOL;
                        }

                    return $this;
                }

            public  function ChartInstance()
                {
                    $str    =   (!empty($this->VarName))? "drawChart({$this->VarName},'{$this->id}');":"";
                    $str    .=  PHP_EOL;

                    return $str;
                }

            public  function CreateJavascript($settings = false)
                {
                    $library    =   (!empty($settings['lib']))? $settings['lib']:false;
                    $wrap       =   (!empty($settings['wrap']))? $settings['wrap']:false;
                    $wrap       =   (!empty($settings['data']) && is_array($settings['data']))? $settings['data']:array();

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

        var chart = new google.visualization.PieChart(document.getElementById(IdElem));

        chart.draw(data, options);
    }';

                    if($wrap)
                        $comp[] =   PHP_EOL.'</script>'.PHP_EOL;

                    return implode("",$comp);
                }
        }
?>