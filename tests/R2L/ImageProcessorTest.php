<?php

namespace R2L;

/**
 * Class ImageProcessorTest
 *
 * @package R2L
 */
class ImageProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new ImageProcessor();
    }

    public function testProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/stub.png');

        $result = file_get_contents(__DIR__ . './../stubs/stub.result.png');

        static::assertResults($contents, $result);
    }
}
