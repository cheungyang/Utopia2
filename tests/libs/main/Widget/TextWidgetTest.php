<?php
class TextWidgetTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($name, $spec, $result)
    {
		$widget = WidgetFactory::getWidget('text');
		$widgetrtn = $widget->execute($name, $spec);
//		pc($widgetrtn);
		$this->assertEquals($result, $widgetrtn['data']);
    }
 
    public static function provider()
    {
    	return array(
			array('A', 	array(),	'<input name="A" type="text" id="A"  />'),
			array('A', 	array('opts'=>array('value'=>'AAA')),	'<input name="A" type="text" id="A" value="AAA"  />'),
		);
    }
}
?>