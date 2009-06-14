<?php
class LabelWidgetTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($name, $spec, $result)
    {
		$widget = WidgetFactory::getWidget('label');
		$widgetrtn = $widget->execute($name, $spec);
//		pc($widgetrtn);
		$this->assertEquals($result, $widgetrtn['data']);
    }
 
    public static function provider()
    {
    	return array(
			array('A', 	array(),	'<label for="A">##labelname##</label>'),
			array('A', 	array('label'=>'AAA'),	'<label for="A">AAA</label>'),
		);
    }
}
?>