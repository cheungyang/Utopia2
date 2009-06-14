<?php
class AllTests
{
	private static function includeTests($indir)
	{
		$indir='/home/utopia/source/tests/current';
		
		$getstr = 'Test.php';
		$getstrlen = -1 * strlen($getstr);
		$filenames = array();
		$dirs = array($indir);

		reset($dirs);
		while (current($dirs) !== false)
		{
			$dir = current($dirs);
			if ($handle = opendir($dir)) {
	    	    while (false !== ($file = readdir($handle))) 
	    	   	{
	    	 		if (substr($file,$getstrlen) == $getstr)
	    	 		{
	    	 			//echo $dir.'/'.$file."<br/>\n";
	    	 			$filenames[] = substr($file, 0, -4);
	    	 			require_once($dir.'/'.$file);
	    	 		}
	    	 		elseif ($file != '.' && $file != '..' && is_dir($dir.'/'.$file))
	    	 		{
	    	 			array_push($dirs, $dir.'/'.$file);
	    	 		}  	
	    	   	}
	    		closedir($handle);    	   
			}    
			next($dirs);
		}
		return $filenames;    	
    }

	public static function suite()
	{
		$dir = '.';
		$filenames = self::includeTests($dir);
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');
		foreach($filenames as $file)
		{
			echo "phpunit: add $file\n";
			$suite->addTestSuite($file);
		}
		return $suite;
	}
}
?>