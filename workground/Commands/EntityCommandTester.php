<?php
function printText($name, $opts)
{
	if (isset($_POST['inputs'][$name])) 
		$value = $_POST['inputs'][$name]; 
	elseif ($opts['default']) 
		$value = $opts['default'];
	else
		$value = '';
		
	$required = $opts['required']? "required": '';
	
	echo <<<CODE
		<tr>		
			<th><label for="$name">$name</label></th>
			<td><input type="text" name="inputs[$name]" value="$value"/></td>
			<td>$required</td>
		</tr>
CODE;
}
function printTextarea($name, $opts)
{
	if (isset($_POST['inputs'][$name])) 
		$value = $_POST['inputs'][$name]; 
	elseif ($opts['default']) 
		$value = $opts['default'];
	else
		$value = '';
		
	$required = $opts['required']? "required": '';
	
	echo <<<CODE
		<tr>		
			<th><label for="$name">$name</label></th>
			<td><textarea name="inputs[$name]">$value</textarea></td>
			<td>$required</td>
		</tr>
CODE;
}
function printSelect($name, $values)
{
	echo "<tr><th><label for=\"$name\">$name</label></th>";
	echo "<td><select name=\"inputs[$name]\">";	
	foreach($values as $val)
	{
		$selected = $_POST[$name]==$val? "selected=\"selected\"": '';	
		echo "<option value=\"$val\" $selected>$val</option>";
	}
	echo "</select></td></tr>";	
}
?>





<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha', 'property'=>'MALLOCWORKS'));
$commandset = 'entity';
$commands = $settings->get('command_'.$commandset);

if (isset($_POST['submit']))
{
	try
	{
		$params = array();
		foreach($_POST['inputs'] as $paramkey => $param)
		{
			if (empty($param))
			{
				continue;
			}
			if (strpos($paramkey, '.') !== false)
			{
				$a = explode('.',$paramkey);
				$params[$a[0]][$a[1]] = $param;
			}
			else
			{
				$params[$paramkey] = $param; 
			}		
		}
		$command = CommandFactory::getCommand(strtolower($_REQUEST['modelname']).'_'.$_REQUEST['commandname'], $params);
		$rtn = $command->execute();
	}
	catch(Exception $e)
	{
		$rtn = "[ERROR] ". $e->getMessage();
	}
}
?>






<form name="commandnames" action="EntityCommandTester.php" method="GET">
	<fieldset>
		<legend>Command List</legend>
		<select name="modelname" onclick="document.forms.commandnames.submit()">
			<?php 
			$schema = $settings->get('schema');
			$models	= array_keys($schema);
			foreach($models as $name): ?>
			<option value="<?php echo $name; ?>" <?php if ($_REQUEST['modelname']==$name) echo "selected=\"selected\"" ?>><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		_		
		<select name="commandname" onclick="document.forms.commandnames.submit()">
			<?php foreach(array_keys($commands) as $name): ?>
			<option value="<?php echo $name; ?>" <?php if ($_REQUEST['commandname']==$name) echo "selected=\"selected\"" ?>><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
</form>







<?php if (isset($_REQUEST['commandname'])): ?>
<form name="commandfields" action="EntityCommandTester.php" method="POST">
	<fieldset>
		<legend>Command Fields</legend>
		<table>
			<?php 
			foreach($commands[$_REQUEST['commandname']]['params'] as $name => $opts)			
			{
				switch($name)
				{
					case 'property': printSelect($name, explode(',',NAME_PROPERTIES)); break;
					case 'model': break;
					case 'flags':
						$columns = array(
							'is_active' => array('default'=>'1'),
							'is_block' 	=> array('default'=>'0'),
							'is_close'  => array('default'=>'0'),
							'is_delete' => array('default'=>'0'),
						);						
						foreach ($columns as $name => $opts)
						{
							printText("flags.$name", $opts);	
						}
						break;
					default: printText($name, $opts);						
					case 'inputs':
						$columns = $settings->get('schema_'.$_REQUEST['modelname'].'_columns');
						if ($settings->get('schema_'.$_REQUEST['modelname'].'_properties_versionable', false))
							$columns['version'] = array();
						if ($settings->get('schema_'.$_REQUEST['modelname'].'_properties_chainable', false))
							$columns['seq'] = array();
						if ($settings->get('schema_'.$_REQUEST['modelname'].'_properties_translateable', false))
							$columns['cult'] = array();
						$columns = array_merge($columns, array(
							'is_active' => array('default'=>'1'),
							'is_block' 	=> array('default'=>'0'),
							'is_close'  => array('default'=>'0'),
							'is_delete' => array('default'=>'0'),
						));
						
						foreach ($columns as $name => $opts)
						{
							$cults = "'".implode("', '", explode(',',NAME_CULTS))."'";
							if ($name == 'cult')
							{
								printSelect("inputs.$name", explode(',',NAME_CULTS));
							}
							elseif(in_array($name, array('version','cult','seq','is_active','is_block','is_close','is_delete')))
							{
								printText("inputs.$name", $opts);	
							}
							else
							{
								printTextarea("inputs.$name", $opts);	
							}							
						}
						break;
					default: printText($name, $opts);
				}				
			}
			?>
		</table>
		<input type="hidden" name="commandname" value="<?php echo $_REQUEST['commandname']; ?>"/>
		<input type="hidden" name="modelname" value="<?php echo $_REQUEST['modelname']; ?>"/>
		<input type="submit" name="submit" value="submit"/>"
	</fieldset>
</form>
<?php endif; ?>





<?php if (isset($rtn)):?>
<fieldset>
	<legend>Command Code</legend>
	<pre>
<?php 
$paramsstr = "array(\n";
foreach ($params as $key => $value)
{
	if (is_array($value))
	{
		$paramsstr .= "\t\t\t'$key' => array(\n";
		foreach ($value as $subkey => $subvalue)
		{
			$paramsstr .= "\t\t\t\t'$subkey' => '$subvalue',\n";
		}
		$paramsstr .= "\t\t\t),\n";
	}
	else
	{	
		$paramsstr .= "\t\t\t'$key' => '$value',\n";
	}
}
$paramsstr .= "\t\t)";
$commandsrr = strtolower($_REQUEST['modelname']).'_'.$_REQUEST['commandname'];
echo <<<CODE
	try
	{
		\$params = $paramsstr;
		\$command = CommandFactory::getCommand('$commandsrr', \$params);
		\$commandrtn = \$command->execute();
	}
	catch(Exception \$e)
	{
		//***error handling
	}
CODE;
?>	
	</pre>
</fieldset>
<?php endif;?>






<?php if (isset($rtn)):?>
<fieldset>
	<legend>Command Result</legend>
	<pre><?php print_r($rtn); ?></pre>
</fieldset>
<?php endif; ?>