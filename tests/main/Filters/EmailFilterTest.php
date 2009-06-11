<?php
class EmailFilterTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($input, $opts, $status)
    {
		$filter = FilterFactory::getFilter('email');
		$filterrtn = $filter->execute($input, $opts);
        $this->assertEquals($status, $filterrtn['status']);
    }
 
    public static function provider()
    {
    	return array(
			array('abc@abc.com', 			array(),	SUCCESS),
			array('j.asdas@yahoo-inc.com',	array(), 	SUCCESS),
			array('j.asdas.asdsa.com', 		array(),	FAIL),
			array('asdsad@@aSDASd.com', 	array(), 	FAIL),
		);
    }
}
?>