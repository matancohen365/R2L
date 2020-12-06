<?php

namespace R2L;

class ImageProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new ImageProcessor();
    }

    public function testProcessing()
    {

        //

        $processor = new ImageProcessor();

        //

        $contents = file_get_contents(__DIR__ . './../stubs/stub.png');

        $result = base64_encode(file_get_contents(__DIR__ . './../stubs/stub.result.png'));

        //

        static::assertEquals(md5($processor->process($contents)), md5($result));

    }
}
