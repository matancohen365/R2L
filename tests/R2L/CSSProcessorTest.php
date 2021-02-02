<?php

namespace Tests\R2L;

use R2L\CSSProcessor;
use R2L\ProcessorInterface;

/**
 * Class CSSProcessorTest
 *
 * @package R2L
 */
class CSSProcessorTest extends AbstractProcessorTest
{
    static public function getProcessor(): ProcessorInterface
    {
        return new CSSProcessor('');
    }

    public function testMarginPaddingAndBordersProcessed()
    {
        static::assertResults('padding:1px;', 'padding:1px;');

        static::assertResults('padding:1px 2px;', 'padding:1px 2px;');

        static::assertResults('padding:1px 2px 3px;', 'padding:1px 2px 3px;');

        static::assertResults('padding:1px 2% 3px 4rem;', sprintf("padding-top: 1px; padding-%s: 2%%; padding-bottom: 3px; padding-%s: 4rem;", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('padding:1px 2% 3px 4rem !important;', sprintf("padding-top: 1px !important; padding-%s: 2%% !important; padding-bottom: 3px !important; padding-%s: 4rem !important;", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('margin:1px;', 'margin:1px;');

        static::assertResults('margin:1px 2px;', 'margin:1px 2px;');

        static::assertResults('margin:1px 2px 3px;', 'margin:1px 2px 3px;');

        static::assertResults('margin:1px 2% 3px 4rem;', sprintf("margin-top: 1px; margin-%s: 2%%; margin-bottom: 3px; margin-%s: 4rem;", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('margin:1px 2% 3px 4rem !important;', sprintf("margin-top: 1px !important; margin-%s: 2%% !important; margin-bottom: 3px !important; margin-%s: 4rem !important;", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('border-radius:1px;', 'border-radius:1px;');

        static::assertResults('border-radius:1px 2px;', 'border-radius:1px 2px;');

        static::assertResults('border-radius:1px 2px 3px;', 'border-radius:1px 2px 3px;');

        static::assertResults('border-radius:1px 2% 3px 4rem;', sprintf("border-top-%s-radius: 1px; border-top-%s-radius: 2%%; border-bottom-%s-radius: 3px; border-bottom-%s-radius: 4rem;", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('border-radius:1px 2% 3px 4rem !important;', sprintf("border-top-%s-radius: 1px !important; border-top-%s-radius: 2%% !important; border-bottom-%s-radius: 3px !important; border-bottom-%s-radius: 4rem !important;", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('.custom-file-label::after { border-radius: 0 .25rem .25rem 0 }', sprintf(".custom-file-label::after { border-top-%s-radius: 0; border-top-%s-radius: .25rem; border-bottom-%s-radius: .25rem; border-bottom-%s-radius: 0}", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));

        static::assertResults('.custom-file-label::after { border-radius: 0 .25rem .25rem 0 !important }', sprintf(".custom-file-label::after { border-top-%s-radius: 0 !important; border-top-%s-radius: .25rem !important; border-bottom-%s-radius: .25rem !important; border-bottom-%s-radius: 0 !important}", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START));
    }

    public function testDirectionsProcessed()
    {
        static::assertResults(sprintf("dir:%s;", CSSProcessor::UPSIDE_DIRECTION), sprintf("dir:%s;", CSSProcessor::DIRECTION));

        static::assertResults(sprintf("body[dir=\"%s\"]", CSSProcessor::UPSIDE_DIRECTION), sprintf("body[dir=\"%s\"]", CSSProcessor::DIRECTION));

        static::assertResults(sprintf("dir:%s;", CSSProcessor::DIRECTION), sprintf("dir:%s;", CSSProcessor::UPSIDE_DIRECTION));

        static::assertResults(sprintf("body[dir=\"%s\"]", CSSProcessor::DIRECTION), sprintf("body[dir=\"%s\"]", CSSProcessor::UPSIDE_DIRECTION));

        static::assertResults(sprintf("wordwith%sinit", CSSProcessor::UPSIDE_DIRECTION), sprintf("wordwith%sinit", CSSProcessor::UPSIDE_DIRECTION));

        static::assertResults(sprintf("wordwith%sinit", CSSProcessor::DIRECTION), sprintf("wordwith%sinit", CSSProcessor::DIRECTION));
    }

    public function testAnglesProcessed()
    {
        static::assertResults('translate(-1px,5px)', 'translate(+1px,5px)');

        static::assertResults('translate ( 12% , 5px )', 'translate ( -12% , 5px )');

        static::assertResults('translate ( +12% , -5px )', 'translate ( -12% , -5px )');

        static::assertResults('translateX(-1px)', 'translateX(+1px)');

        static::assertResults('translateX(-1%)', 'translateX(+1%)');

        static::assertResults('translateX(1rem)', 'translateX(-1rem)');

        static::assertResults('translateX(1%)', 'translateX(-1%)');

        static::assertResults('translate3d(-1px,5px,1%)', 'translate3d(+1px,5px,1%)');

        static::assertResults('translate3d(1px,5px,1%)', 'translate3d(-1px,5px,1%)');

        static::assertResults('translate3d(+1px,5px,1%)', 'translate3d(-1px,5px,1%)');
    }

    public function testRulesProcessed()
    {
        static::assertResults(sprintf("%s:0px;", CSSProcessor::DIRECTION_END), sprintf("%s:0px;", CSSProcessor::DIRECTION_START));

        static::assertResults(sprintf("%s  :  0px ;", CSSProcessor::DIRECTION_END), sprintf("%s  :  0px ;", CSSProcessor::DIRECTION_START));

        static::assertResults(sprintf("text : %s;", CSSProcessor::DIRECTION_END), sprintf("text : %s;", CSSProcessor::DIRECTION_START));

        static::assertResults(sprintf("copy%s", CSSProcessor::DIRECTION_START), sprintf("copy%s", CSSProcessor::DIRECTION_START));

        static::assertResults(sprintf(".%s-text { %s:%s; }", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START), sprintf(".%s-text { %s:%s; }", CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END));

        static::assertResults(sprintf(".%s-text { %s:%s; }", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START), sprintf(".%s-text { %s:%s; }", CSSProcessor::DIRECTION_END, CSSProcessor::DIRECTION_START, CSSProcessor::DIRECTION_END));
    }
}
