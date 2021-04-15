<?php

namespace Tests\R2L;

use R2L\ImageProcessor;
use R2L\ProcessorInterface;

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
        $contents = file_get_contents(__DIR__ . './../stubs/png.stub');

        $result = file_get_contents(__DIR__ . './../stubs/result.png.stub');

        static::assertResults($contents, $result);
    }
}
