<?php
echo <<<ECHO
---------------------------------------
+  
+    $argv[0]
+
---------------------------------------\n
ECHO;
if ($argc != 2)
{
	echo "syntax: php {$argv[0]} [property]\n";
	die();
}
$property = strtoupper($argv[1]);

require_once('../libs/main/Config/SettingFactory.php');

$settings = SettingFactory::getSettings(array('env'=>'alpha', 'property'=>$property));
$manager = $settings->getManager();
$dbenv = $settings->get('database_'.$property.'_alpha');
$conn = Doctrine_Manager::connection($dbenv['default']['dsn'], 'default');

$filename = DIR_CONF_ROOT .'doctrine/'.strtolower($property).'.yml';
$dirname = DIR_MODULE_ROOT. strtolower($property);

echo "read yml file $filename ...";
if (file_exists($filename) === TRUE)
{
	echo "[OK]\n";
}
else
{
	echo "[NOT FOUND]\n";
	die("[FAIL]\n");
} 

echo "building models at $dirname...";
Doctrine::dropDatabases();
Doctrine::createDatabases();
Doctrine::generateModelsFromYaml($filename, $dirname);
Doctrine::createTablesFromModels($dirname);
echo "[OK]\n";