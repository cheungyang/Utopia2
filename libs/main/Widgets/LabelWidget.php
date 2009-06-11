<?php
class LabelWidget extends InputWidget implements IWidget
{
	protected function doExecute()
	{
		return sprintf("<label for=\"%s\">%s</label>", $this->_name, $this->_spec['label']);
	}
}
?>
