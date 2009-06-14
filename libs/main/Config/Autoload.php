<?php
function debug($message)
{
	echo "$message\n";
}

function autoLoader($className){

	$property = getenv('PROPERTY') !== false? strtolower(getenv('PROPERTY')).'/': '';

	//array(dirname, depth)
	$directories = array(
      	array(DIR_LIB_ROOT.'main/', 999),		
      	array(DIR_MODULE_ROOT. $property, 999),
		array(DIR_LIB_ROOT.'vendor/', 0),      	
    );
    
//    foreach($directories as $dir)
//    {
//    	debug("[autoload] {$dir[0]}, level {$dir[1]}");
//    }

    $fileNameFormats = array(
      '%s.php',
    );

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if(@include_once $path.'.php'){
    	debug("[found] $path");
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
            	debug("[found] $path");
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