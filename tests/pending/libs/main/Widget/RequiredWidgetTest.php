<?php
class RequiredWidgetTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($name, $spec, $result)
    {
		$widget = WidgetFactory::getWidget('required');
		$widgetrtn = $widget->execute($name, $spec);
		$this->assertEquals($widgetrtn['status'], SUCCESS);
		if ($widgetrtn['status'] === SUCCESS)
		{
			$this->assertEquals($widgetrtn['data'], $result);
		}
    }
 
    public static function provider()
    {
    	return array(
			array('A', 	array(),	''),
			array('A', 	array('required'=>'true'),	''),
		);
    }
}
?>