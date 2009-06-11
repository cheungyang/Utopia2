<?php
class PasswordFilterTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($input, $opts, $status)
    {
		$filter = FilterFactory::getFilter('password');
		$filterrtn = $filter->execute($input, $opts);		
        $this->assertEquals($status, $filterrtn['status']);
    }
 
    public static function provider()
    {
    	return array(
			array('ASDasdasd@#$4134#!$#', 	array('strength'=>4),	SUCCESS),
			array(1,						array(), 				SUCCESS),
			array('$@#!$%^#@$&$%@*$*', 		array('strength'=>4),	FAIL),
			array('234234324', 				array('strength'=>1), 	SUCCESS),
		);
    }
}
?>