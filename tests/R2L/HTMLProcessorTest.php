<?php

namespace Tests\R2L;

use R2L\CSSProcessor;
use R2L\HTMLProcessor;
use R2L\ProcessorInterface;

/**
 * Class HTMLProcessorTest
 * @package R2L
 */
class HTMLProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new HTMLProcessor(new CSSProcessor(''));
    }

    public function testHTMLTagShouldHaveDirRTLAfterProcessing()
    {
        static::assertResults('<html dir="ltr"></html>', '<html dir="rtl"></html>');

        static::assertResults('<html lang="en"></html>', '<html lang="en" dir="rtl"></html>');

        static::assertResults('<html class="abc"></html>', '<html class="abc" dir="rtl"></html>');
    }

    /**
     * @see CSSProcessorTest
     */
    public function testStyleTagShouldBeProcessed()
    {
        static::assertResults(
            '<style> .kls { float:right; } </style>',
            '<style> .kls { float:left; } </style>');

        static::assertResults(
            '<style> #id { margin:1px 2% 3px 4rem; } </style>',
            '<style> #id { margin-top: 1px; margin-left: 2%; margin-bottom: 3px; margin-right: 4rem; } </style>');

    }

    /**
     * @see CSSProcessorTest
     */
    public function testStyleAttrShouldBeProcessed()
    {
        static::assertResults(
            '<p style="float: right;"> HEY </p>',
            '<p style="float: left;"> HEY </p>');

        static::assertResults(
            '<p style="margin:1px 99cm 3px 4rem;"></p>',
            '<p style="margin-top: 1px; margin-left: 99cm; margin-bottom: 3px; margin-right: 4rem;"></p>');

    }
}
