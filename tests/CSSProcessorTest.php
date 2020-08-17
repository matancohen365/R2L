<?php

namespace AutoRTL;

use PHPUnit\Framework\TestCase;

class CSSProcessorTest extends TestCase
{

    const PREPEND_RULES = CSSProcessor::PREPEND_RULES;

    public function testProcess()
    {

        $this->testPrependRules();

        $this->testTransformMarginPaddingBorders();

        $this->testTransformDirection();

        $this->testTransformAngles();

        $this->testTransformRules();

    }

    public function testTransformMarginPaddingBorders()
    {

        $cp = new CSSProcessor();

        // padding

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px;', $cp->process('padding:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px 2px;', $cp->process('padding:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px 2px 3px;', $cp->process('padding:1px 2px 3px;'));


        $contents = 'padding:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "padding-top: 1px ;\npadding-left: 2% ;\npadding-bottom: 3px ;\npadding-right: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'padding:1px 2% 3px 4rem !important;';
        $expected = self::PREPEND_RULES . "padding-top: 1px !important;\npadding-left: 2% !important;\npadding-bottom: 3px !important;\npadding-right: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

        // margin

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px;', $cp->process('margin:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px 2px;', $cp->process('margin:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px 2px 3px;', $cp->process('margin:1px 2px 3px;'));


        $contents = 'margin:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "margin-top: 1px ;\nmargin-left: 2% ;\nmargin-bottom: 3px ;\nmargin-right: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'margin:1px 2% 3px 4rem !important;';
        $expected = self::PREPEND_RULES . "margin-top: 1px !important;\nmargin-left: 2% !important;\nmargin-bottom: 3px !important;\nmargin-right: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

        // border-radius

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px;', $cp->process('border-radius:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px 2px;', $cp->process('border-radius:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px 2px 3px;', $cp->process('border-radius:1px 2px 3px;'));


        $contents = 'border-radius:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "border-top-right-radius: 1px ;\nborder-top-left-radius: 2% ;\nborder-bottom-left-radius: 3px ;\nborder-bottom-right-radius: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'border-radius:1px 2% 3px 4rem !important;';
        $expected = self::PREPEND_RULES . "border-top-right-radius: 1px !important;\nborder-top-left-radius: 2% !important;\nborder-bottom-left-radius: 3px !important;\nborder-bottom-right-radius: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

    }

    public function testTransformDirection()
    {

        $cp = new CSSProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'dir:rtl;', $cp->process('dir:ltr;'));

        $this->assertEquals(self::PREPEND_RULES . 'body[dir="rtl"]', $cp->process('body[dir="ltr"]'));

        $this->assertEquals(self::PREPEND_RULES . 'dir:ltr;', $cp->process('dir:rtl;'));

        $this->assertEquals(self::PREPEND_RULES . 'body[dir="ltr"]', $cp->process('body[dir="rtl"]'));

        $this->assertEquals(self::PREPEND_RULES . 'wordwithltrinit', $cp->process('wordwithltrinit'));

        $this->assertEquals(self::PREPEND_RULES . 'wordwithrtlinit', $cp->process('wordwithrtlinit'));

    }

    public function testTransformAngles()
    {

        $cp = new CSSProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'translate(1px,5px)', $cp->process('translate(-1px,5px)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate ( -12% , 5px )', $cp->process('translate ( 12% , 5px )'));
        $this->assertEquals(self::PREPEND_RULES . 'translate ( -12% , -5px )', $cp->process('translate ( +12% , -5px )'));

        $this->assertEquals(self::PREPEND_RULES . 'translateX(1px)', $cp->process('translateX(-1px)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(1%)', $cp->process('translateX(-1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(-1rem)', $cp->process('translateX(1rem)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(-1%)', $cp->process('translateX(1%)'));

        $this->assertEquals(self::PREPEND_RULES . 'translate3d(1px,5px,1%)', $cp->process('translate3d(-1px,5px,1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate3d(-1px,5px,1%)', $cp->process('translate3d(1px,5px,1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate3d(-1px,5px,1%)', $cp->process('translate3d(+1px,5px,1%)'));
    }

    public function testTransformRules()
    {

        $cp = new CSSProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'right:0px;', $cp->process('left:0px;'));
        $this->assertEquals(self::PREPEND_RULES . 'right  :  0px  ;', $cp->process('left  :  0px  ;'));
        $this->assertEquals(self::PREPEND_RULES . 'text : right ;', $cp->process('text : left ;'));
        $this->assertEquals(self::PREPEND_RULES . 'copyright', $cp->process('copyright'));
        $this->assertEquals(self::PREPEND_RULES . '.right-text { right:left; }', $cp->process('.right-text { left:right; }'));
        $this->assertEquals(self::PREPEND_RULES . '.left-text { right:left; }', $cp->process('.left-text { left:right; }'));
    }


    public function testPrependRules()
    {

        $cp = new CSSProcessor();

        $this->assertEquals(self::PREPEND_RULES, $cp->process(''));

    }
}
