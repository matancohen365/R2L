<?php

namespace R2L;

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
            file_get_contents(__DIR__ . './../stubs/stub.template.locale.json')
        );
    }

    public function testProcessing()
    {
        $contents = file_get_contents(__DIR__ . './../stubs/stub.locale.json');

        $result = file_get_contents(__DIR__ . './../stubs/stub.result.locale.json');

        self::assertResults($contents, $result);
    }
}
