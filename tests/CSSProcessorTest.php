<?php

namespace AutoRTL;

require_once 'AbstractProcessorTest.php';

class CSSProcessorTest extends AbstractProcessorTest
{

    static public function getProcessor(): ProcessorInterface
    {
        return new CSSProcessor();
    }

    public function testTransformMarginPaddingBorders()
    {
        static::assertResults('padding:1px;', 'padding:1px;');

        static::assertResults('padding:1px 2px;', 'padding:1px 2px;');

        static::assertResults('padding:1px 2px 3px;', 'padding:1px 2px 3px;');

        static::assertResults('padding:1px 2% 3px 4rem;', 'padding-top: 1px; padding-left: 2%; padding-bottom: 3px; padding-right: 4rem;');

        static::assertResults('padding:1px 2% 3px 4rem !important;', 'padding-top: 1px !important; padding-left: 2% !important; padding-bottom: 3px !important; padding-right: 4rem !important;');

        static::assertResults('margin:1px;', 'margin:1px;');

        static::assertResults('margin:1px 2px;', 'margin:1px 2px;');

        static::assertResults('margin:1px 2px 3px;', 'margin:1px 2px 3px;');

        static::assertResults('margin:1px 2% 3px 4rem;', 'margin-top: 1px; margin-left: 2%; margin-bottom: 3px; margin-right: 4rem;');

        static::assertResults('margin:1px 2% 3px 4rem !important;', 'margin-top: 1px !important; margin-left: 2% !important; margin-bottom: 3px !important; margin-right: 4rem !important;');

        static::assertResults('border-radius:1px;', 'border-radius:1px;');

        static::assertResults('border-radius:1px 2px;', 'border-radius:1px 2px;');

        static::assertResults('border-radius:1px 2px 3px;', 'border-radius:1px 2px 3px;');

        static::assertResults('border-radius:1px 2% 3px 4rem;', 'border-top-right-radius: 1px; border-top-left-radius: 2%; border-bottom-left-radius: 3px; border-bottom-right-radius: 4rem;');

        static::assertResults('border-radius:1px 2% 3px 4rem !important;', 'border-top-right-radius: 1px !important; border-top-left-radius: 2% !important; border-bottom-left-radius: 3px !important; border-bottom-right-radius: 4rem !important;');

        static::assertResults('.custom-file-label::after { border-radius: 0 .25rem .25rem 0 }', '.custom-file-label::after { border-top-right-radius: 0; border-top-left-radius: .25rem; border-bottom-left-radius: .25rem; border-bottom-right-radius: 0}');

        static::assertResults('.custom-file-label::after { border-radius: 0 .25rem .25rem 0 !important }', '.custom-file-label::after { border-top-right-radius: 0 !important; border-top-left-radius: .25rem !important; border-bottom-left-radius: .25rem !important; border-bottom-right-radius: 0 !important}');
    }

    public function testTransformDirection()
    {
        static::assertResults('dir:ltr;', 'dir:rtl;');

        static::assertResults('body[dir="ltr"]', 'body[dir="rtl"]');

        static::assertResults('dir:rtl;', 'dir:ltr;');

        static::assertResults('body[dir="rtl"]', 'body[dir="ltr"]');

        static::assertResults('wordwithltrinit', 'wordwithltrinit');

        static::assertResults('wordwithrtlinit', 'wordwithrtlinit');
    }

    public function testTransformAngles()
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

    public function testTransformRules()
    {
        static::assertResults('left:0px;', 'right:0px;');

        static::assertResults('left  :  0px ;', 'right  :  0px ;');

        static::assertResults('text : left;', 'text : right;');

        static::assertResults('copyright', 'copyright');

        static::assertResults('.right-text { left:right; }', '.right-text { right:left; }');

        static::assertResults('.left-text { left:right; }', '.left-text { right:left; }');
    }
}
