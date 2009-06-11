<?php
require_once DIR_LIB_ROOT. 'vendor/PHPUnit/PHPUnit/Extensions/PerformanceTestCase.php';

class SleepTest extends PHPUnit_Extensions_PerformanceTestCase
{
    public function testSleepTwoSeconds()
    {
        sleep(2);
    }
}
?>
