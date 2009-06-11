<?php
class InfoWidget extends InputWidget implements IWidget
{
	protected function doExecute()
	{
		return sprintf("<span class=\"info\">%s</span>", $this->_spec['info']);
	}
}
?>
