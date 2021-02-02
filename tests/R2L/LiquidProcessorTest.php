<?php

namespace Tests\R2L;

use R2L\CSSProcessor;
use R2L\EmptyProcessor;
use R2L\LiquidProcessor;
use R2L\ProcessorInterface;

/**
 * Class LiquidProcessorTest
 *
 * @package R2L
 */
class LiquidProcessorTest extends AbstractProcessorTest
{
    public static function getProcessor(): ProcessorInterface
    {
        return new LiquidProcessor(new EmptyProcessor());
    }

    public function testVariablesContentShouldBeEqualsAfterProcessing()
    {
        static::assertResults(
            '.cls { right : {{ shop.key }} ; }',
            '.cls { left : {{ shop.key }} ; }',
            'variables content should be equals after processing',
            new LiquidProcessor(new CSSProcessor('')),
        );

    }

    public function testConditionsContentShouldBeEqualsAfterProcessing()
    {

        $contents = $expected = <<<EOL
{% if true and false and false or true %}
  This evaluates to false, since the tags are checked like this:

  true and (false and (false or true))
  true and (false and true)
  true and false
  false
{% endif %}
EOL;

        static::assertResults($contents, $expected,
            'conditions content should be equals after processing');

    }
}
