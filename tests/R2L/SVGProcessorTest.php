<?php

namespace R2L;

use PHPUnit\Framework\TestCase;

/**
 * Class SVGProcessorTest
 *
 * @package R2L
 * @deprecated
 */
class SVGProcessorTest extends TestCase
{
    public function testProcessing()
    {

        //

        $processor = new SVGProcessor();

        //

        $contents = file_get_contents(__DIR__ . './../stubs/stub.svg.html');

        $result = file_get_contents(__DIR__ . './../stubs/stub.result.svg.html');

        //

        static::assertEquals($processor->process($contents), $result);

    }
}
