<?php
/**
 * Created by PhpStorm.
 * User: jesus
 * Date: 2/09/18
 * Time: 14:20
 */

namespace AppBundle\Util;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        // Assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}
