<?php
require_once DIR_LIB_ROOT. 'vendor/PHPUnit/PHPUnit/Extensions/OutputTestCase.php';

class OutputTestCase extends PHPUnit_Extensions_OutputTestCase
{
    public function testExpectOutputStringFooActualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    public function testExpectOutputStringFooActualBar()
    {
        $this->expectOutputString('foo');
        print 'bar';
    }

    public function testExpectOutputRegexFooActualFoo()
    {
        $this->expectOutputRegex('/foo/');
        print 'foo';
    }

    public function testExpectOutputRegexFooActualBar()
    {
        $this->expectOutputRegex('/foo/');
        print 'bar';
    }
}
?>
