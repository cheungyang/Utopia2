<?php
class NumberFilterTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($input, $opts, $status)
    {
		$filter = FilterFactory::getFilter('number');
		$filterrtn = $filter->execute($input, $opts);
        $this->assertEquals($status, $filterrtn['status']);
    }
 
    public static function provider()
    {
    	return array(
			array('1', 						array(),	SUCCESS),
			array('1,000,000,000',			array(), 	SUCCESS),
			array('+123213.123123', 		array(),	SUCCESS),
			array('12323a', 				array(), 	FAIL),
		);
    }
}
?>