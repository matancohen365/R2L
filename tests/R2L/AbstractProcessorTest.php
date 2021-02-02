<?php

namespace Tests\R2L;

use PHPUnit\Framework\TestCase;
use R2L\ProcessorInterface;

/**
 * Class AbstractProcessorTest
 *
 * @package R2L
 */
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
