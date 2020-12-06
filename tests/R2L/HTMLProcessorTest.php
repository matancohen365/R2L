<?php

namespace R2L;

class HTMLProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new HTMLProcessor();
    }

    public function testDirectionsProcessed()
    {
        static::assertResults('<html dir="ltr"></html>', '<html dir="rtl"></html>');

        static::assertResults('<html lang="en"></html>', '<html lang="en" dir="rtl"></html>');

        static::assertResults('<style> #id { margin:1px 2% 3px 4rem; } </style>', '<style> #id { margin-top: 1px; margin-left: 2%; margin-bottom: 3px; margin-right: 4rem; } </style>');

        static::assertResults('<html class="abc"></html>', '<html class="abc" dir="rtl"></html>');

        static::assertResults('<p style="float: right;"> HEY </p>', '<p style="float: left;"> HEY </p>');

        static::assertResults('<p style="text-align: left;"></p>', '<p style="text-align: right;"></p>');
    }
}
