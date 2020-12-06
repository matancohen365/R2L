<?php

namespace R2L;

class JavaScriptProcessorTest extends AbstractProcessorTest
{

    static public function getProcessor(): ProcessorInterface
    {
        return new JavaScriptProcessor();
    }

    public function testDirectionsProcessed()
    {
        static::assertResults('rtl:!1;', 'rtl:true;');
    }
}
