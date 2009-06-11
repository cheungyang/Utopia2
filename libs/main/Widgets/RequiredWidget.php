<?php
class RequiredWidget extends InputWidget implements IWidget
{
	protected function doExecute()
	{		
		return $this->_spec['required'] === true? "<span class=\"required\">required</span>": "";
	}
}
?>
