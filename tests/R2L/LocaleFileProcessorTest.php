<?php

namespace Tests\R2L;

use R2L\LocaleFileProcessor;
use R2L\ProcessorInterface;

/**
 * Class LocaleFileProcessorTest
 *
 * @package R2L
 */
class LocaleFileProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new LocaleFileProcessor(
            file_get_contents(__DIR__ . './../stubs/template.locale.json.stub')
        );
    }

    public function testProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/locale.json.stub');

        $result = file_get_contents(__DIR__ . './../stubs/result.locale.json.stub');

        self::assertResults($contents, $result);
    }
}
