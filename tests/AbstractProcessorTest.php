<?php

namespace AutoRTL;

use PHPUnit\Framework\TestCase;

abstract class AbstractProcessorTest extends TestCase
{

    public static function assertResults($contents, $expected, string $message = ''): void
    {
        static::assertEquals(static::getProcessor()->process('') . $expected, static::getProcessor()->process($contents), $message);
    }

    abstract static public function getProcessor(): ProcessorInterface;
}
