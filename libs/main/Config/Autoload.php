<?php

function autoLoader($className){

	//array(dirname, depth)
	$directories = array(
      	array(DIR_LIB_ROOT.'main/', 999),		
      	array(DIR_APP_ROOT.'models/', 999),
		array(DIR_LIB_ROOT.'vendor/', 0),      	
    );

    $fileNameFormats = array(
      '%s.php',
    );

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if(@include_once $path.'.php'){
    	//echo "found: $path\n";
        return;
    }
   
    reset($directories);
    while(current($directories) !== false)
    {
    	$directorylist = current($directories);
    	$directory = $directorylist[0];
    	//1. find files
        foreach($fileNameFormats as $fileNameFormat){
            $path = $directory.sprintf($fileNameFormat, $className);
            if(file_exists($path)){
            	//echo "found: $path\n";
                include_once $path;
                return;
            }
        }
       	//2. if not found, find subdirectories
       	if ($directorylist[1] > 0)
       	{
	       	$subdir = array();
	       	if($handle = opendir($directory)) 
	       	{
				while(false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..' && is_dir($directory.$file.'/'))
					{
						$directories[] = array($directory.$file.'/', $directorylist[1] -1);
					}
				}
	       	} 
       	}
       	next($directories);
    }
}

spl_autoload_register('autoLoader');
?>