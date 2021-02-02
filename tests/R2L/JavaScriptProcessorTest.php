<?php

namespace Tests\R2L;

use R2L\JavaScriptProcessor;
use R2L\ProcessorInterface;

/**
 * Class JavaScriptProcessorTest
 *
 * @package R2L
 */
class JavaScriptProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new JavaScriptProcessor();
    }

    public function testSlickJSProcessed()
    {
        static::assertResults('rtl:!1;', 'rtl:true;');
    }
}
