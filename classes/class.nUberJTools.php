<?php
	class	nUberJTools
		{
			protected	static	$jQObj = '$';
			
			private		static	$GoogleCharts;
			private		static	$jQValidator;
			private		static	$jQueryAjax;
			
			const	WP_COMPAT	=	'jQuery';
			
			private	function __construct()
				{
				}
			
			public	static	function Initialize()
				{
					$argsCnt	=	func_num_args();
					
					if($argsCnt == 1) {
							$args			=	func_get_args();
							self::$jQObj	=	$args[0];
						}
				}
			
			public	static	function GoogleCharts()
				{
					if(empty(self::$GoogleCharts)) {
							include_once(__DIR__.'/class.GoogleCharts.php');
							self::$GoogleCharts	=	new GoogleCharts(self::$jQObj);
						}
					
					return self::$GoogleCharts;
				}
			
			public	static	function jQueryValidator()
				{
					if(empty(self::$jQValidator)) {
							include_once(__DIR__.'/class.jQueryValidator.php');
							self::$jQValidator	=	new jQueryValidator(self::$jQObj);
						}
					
					return self::$jQValidator;
				}
			
			public	static	function jQueryAjax()
				{
					if(empty(self::$jQueryAjax)) {
							include_once(__DIR__.'/class.jQueryAjax.php');
							self::$jQueryAjax	=	new jQueryAjax(self::$jQObj);
						}
					
					return self::$jQueryAjax;
				}
			
			public	static	function DocumentReady($val = false)
				{
					ob_start();
					echo self::$jQObj; ?>(document).ready(function() { <?php
					echo PHP_EOL;
					echo $val;
					?>
					}); 
					<?php
					$data =	ob_get_contents();
					ob_end_clean();
					return $data;
				}
		}
?>
