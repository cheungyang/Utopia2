<?php
class TextWidget extends InputWidget implements IWidget
{
	protected function doExecute()
	{
		return $this->filterSpec('text');
	}
}
?>
