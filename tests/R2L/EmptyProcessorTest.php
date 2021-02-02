<?php

namespace Tests\R2L;

use R2L\ProcessorInterface;
use R2L\EmptyProcessor;

/**
 * Class EmptyProcessorTest
 *
 * @package R2L
 */
class EmptyProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new EmptyProcessor();
    }

    public function testHTMLContentShouldBeEqualsAfterProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/stub.html');

        self::assertResults($contents, $contents);
    }

    public function testCSSContentShouldBeEqualsAfterProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/stub.css');

        self::assertResults($contents, $contents);
    }

    public function testJSContentShouldBeEqualsAfterProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/js.stub');

        self::assertResults($contents, $contents);
    }
}
