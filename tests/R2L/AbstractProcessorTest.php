<?php

namespace R2L;

use PHPUnit\Framework\TestCase;

abstract class AbstractProcessorTest extends TestCase
{

    public static function assertResults(string $contents, string $expected, ?string $message = '', ?ProcessorInterface $processor = null): void
    {
        $processor ??= static::getProcessor();

        static::assertEquals(
            $expected,
            $processor->process($contents),
            $message,
        );
    }

    abstract static public function getProcessor(): ProcessorInterface;
}
