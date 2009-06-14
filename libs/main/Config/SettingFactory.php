<?php
require_once('Constant.php');
//move the include class here to make use of the dimension variable.
require_once('Autoload.php');

class SettingFactory
{
	static private $settings = array();
	static private $cursettings = array();
	private $dimension = array();
	private $config = array(), $cacheconfig = array();
	private $objects = array();
	
	/*
	 * all settings variables are put here
	 */
	private function configSettings()
	{
		error_reporting(-1);	

		/* ===============================
		 * Help class definition
		 * =============================== */
		HelperFactory::getHelpers('debug');
				
		/* ===============================
		 * setting dimension settings
		 * =============================== */
		$this->spec = array(
			'env'=>array('required'=>true),
			'property'=>array('required'=>true),
		);		
	}
	
	static function getSettings($dimensions=array())
	{		
		if (empty($dimensions) && !empty(self::$cursettings))
		{
			$dimensions = self::$cursettings;
		}
		elseif (empty($dimensions))
		{
			throw new Exception("dimension information cannot be loaded", ERROR_REQUIRED_MISSING);
		}

		$dimensionstr = serialize($dimensions);
		if (!isset(self::$settings[$dimensionstr]))
		{
			self::$settings[$dimensionstr] = new self($dimensions);
		}

		self::$cursettings = $dimensions;
		return self::$settings[$dimensionstr];
	}	
	
	private function __construct($dimension)
	{				
		$this->configSettings();
				
		$validator = ValidatorFactory::getValidator($dimension, $this->spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === SUCCESS)
		{
			$this->dimension = $validatorrtn['data'];
			foreach ($this->dimension as $key => $val)
			{
				putenv(strtoupper($key)."=$val");
				debug("[putenv] ".strtoupper($key)."=$val" );
			}	
		}
		else
		{
			//TODO: throw multiple errors
			throw $validatorrtn['errors'][0];
		}		
	
	}

	public function get($name, $default=null, $folder='database')
	{
		if (isset($this->cacheconfig[$name]))
		{
			return $this->cacheconfig[$name];
		}		
			
	    $struct = explode('_',$name);
    	if (!isset($this->config[$struct[0]])) //get file
	    {
	    	$filename = DIR_CONF_ROOT.$folder.'/'.$struct[0].'.yml';
	    	//echo $filename;
	    	if (file_exists($filename))
	    	{
	    	    ob_start();		
	    		include($filename); //include to parse php tags in yml
	    		$filestr = ob_get_contents();
	    		if (!empty($replaces))
	    		{
	    			$filestr = vsprintf($filestr, $replaces);
	    		}    			    		
	    		ob_end_clean();
				$this->config[$struct[0]] = Yaml::load($filestr);
	    	}
			elseif (is_null($default))
			{
				throw new Exception("parameter '$name' cannot be loaded", ERROR_CONFIG_RETURN_FALSE);
			}
			else
			{				
				return $default;
			}
	    }
	    
	    $count = count($struct);	//get config
	   	$config = $this->config[$struct[0]];
	    for($i=1; $i<$count; $i++)
	    {
	    	$longeststr = implode('_',array_slice($struct, $i));
	    	if (isset($config[$longeststr]))
	    	{
    			return $config[$longeststr];
	    	}	    		
	    	elseif (isset($config[$struct[$i]]))
	    	{
	    		$config = $config[$struct[$i]];
	    	}
   			elseif (is_null($default))
			{
				throw new Exception("parameter '$name' returns nothing", ERROR_CONFIG_RETURN_FALSE);
			}
			else
			{
				return $default;
			}
	    }
	    
		$this->cacheconfig[$name] = $config;	//for faster fetching
		return $config;	    
	}
	
	public function getManager()
	{	
		$filename = realpath(DIR_LIB_ROOT."vendor/Doctrine.php");
		if ($filename !== false && !in_array($filename, get_required_files()))
		{
			require_once($filename);
			debug("[found] $filename");		
			spl_autoload_register(array('Doctrine', 'autoload'));	
		}	
		return Doctrine_Manager::getInstance();
	}
	
	public function getConnection($name='default')
	{
		//make sure Doctrine class is loaded
		$this->getManager();
		
		if (isset($this->objects['connections'][$name]))
		{
			return $this->objects['connections'][$name];
		}
					
		$dbenv = $this->get('database_'.$this->dimension['env']);
		if (isset($dbenv[$name]['dsn']))
		{
			$conn = Doctrine_Manager::connection($dbenv[$name]['dsn'], $name);
			$this->objects['connections'][$name] = $conn;
			return $conn;
		}
		else
		{
			throw new Exception('cannot find var $dbenv[$name][\'dsn\']', ERROR_VAR_NOT_FOUND);
		}
	}	
	
	public function getDimension($name, $default=null)
	{
		return isset($this->dimension[$name])?
			$this->dimension[$name]:
			$default;			
	}
}
