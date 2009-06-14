<?php
class StringFilterTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($input, $opts, $status)
    {
		$filter = FilterFactory::getFilter('string');
		$filterrtn = $filter->execute($input, $opts);
        $this->assertEquals($status, $filterrtn['status']);
    }
 
    public static function provider()
    {
    	return array(
			array('asdasdasdsd', 			array(),	SUCCESS),
			array('sdfasffs32asdasdsadd',	array(), 	SUCCESS),
			array('§ä§Ú¶Ü', 					array(),	SUCCESS),
			array('§Úd3213213213', 			array(), 	FAIL),
			array('!@#!%$!%!#^%', 			array(), 	FAIL),
		);
    }
}
?>