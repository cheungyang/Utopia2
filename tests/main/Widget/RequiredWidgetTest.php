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
		pc($widgetrtn);
		$this->assertEquals($result, $widgetrtn['data']);
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