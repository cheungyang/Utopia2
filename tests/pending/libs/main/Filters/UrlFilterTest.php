<?php
class UrlFilterTest extends PhpunitClass
{
	/**
	 * @dataProvider provider
	 */
    public function testFilter($input, $opts, $status)
    {
		$filter = FilterFactory::getFilter('url');
		$filterrtn = $filter->execute($input, $opts);
        $this->assertEquals($status, $filterrtn['status']);
    }
 
    public static function provider()
    {
    	return array(
			array('http://www.symfony-project.org/tutorial/1_0/my-first-project', 							array(),	SUCCESS),
			array('http://localhost/utopia/tests/main/Commands/EntityCommandTester.php?commandname=add',	array(), 	SUCCESS),
			array('http://localhost/utopia/tests/main/Commands/EntityCommandTester.php?commandname=add?a=a',array(),	FAIL),
			array('http://hk.myblog.yahoo.com/rebecca1960hk/article?mid=1600'. urlencode(serialize('http://hk.myblog.yahoo.com/rebecca1960hk/article?mid=1600')), array(), 	SUCCESS),
		);
    }
}
?>