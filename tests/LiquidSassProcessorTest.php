<?php

namespace AutoRTL;

use PHPUnit\Framework\TestCase;

class LiquidSassProcessorTest extends TestCase
{

    const PREPEND_RULES = LiquidSassProcessor::PREPEND_RULES;

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

        $cp = new LiquidSassProcessor();

        // padding /* top | right | bottom | left */

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px;', $cp->process('padding:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px 2px;', $cp->process('padding:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'padding:1px 2px 3px;', $cp->process('padding:1px 2px 3px;'));


        $contents = 'padding:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "padding-top: 1px ;\npadding-#{\$direction_end}: 2% ;\npadding-bottom: 3px ;\npadding-#{\$direction_start}: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'padding:1px 2% 3px 4rem !important;';
        $expected = self::PREPEND_RULES . "padding-top: 1px !important;\npadding-#{\$direction_end}: 2% !important;\npadding-bottom: 3px !important;\npadding-#{\$direction_start}: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

        // margin

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px;', $cp->process('margin:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px 2px;', $cp->process('margin:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'margin:1px 2px 3px;', $cp->process('margin:1px 2px 3px;'));


        $contents = 'margin:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "margin-top: 1px ;\nmargin-#{\$direction_end}: 2% ;\nmargin-bottom: 3px ;\nmargin-#{\$direction_start}: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'margin:1px function(2+5*3, 23) $var 4rem !important;';
        $expected = self::PREPEND_RULES . "margin-top: 1px !important;\nmargin-#{\$direction_end}: function(2+5*3, 23) !important;\nmargin-bottom: \$var !important;\nmargin-#{\$direction_start}: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

        // border-radius

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px;', $cp->process('border-radius:1px;'));

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px 2px;', $cp->process('border-radius:1px 2px;'));

        $this->assertEquals(self::PREPEND_RULES . 'border-radius:1px 2px 3px;', $cp->process('border-radius:1px 2px 3px;'));


        $contents = 'border-radius:1px 2% 3px 4rem;';
        $expected = self::PREPEND_RULES . "border-top-#{\$direction_start}-radius: 1px ;\nborder-top-#{\$direction_end}-radius: 2% ;\nborder-bottom-#{\$direction_end}-radius: 3px ;\nborder-bottom-#{\$direction_start}-radius: 4rem ;\n";
        $this->assertEquals($expected, $cp->process($contents));

        $contents = 'border-radius:1px 2% 3px 4rem !important;';
        $expected = self::PREPEND_RULES . "border-top-#{\$direction_start}-radius: 1px !important;\nborder-top-#{\$direction_end}-radius: 2% !important;\nborder-bottom-#{\$direction_end}-radius: 3px !important;\nborder-bottom-#{\$direction_start}-radius: 4rem !important;\n";
        $this->assertEquals($expected, $cp->process($contents));

    }

    public function testTransformDirection()
    {

        $cp = new LiquidSassProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'body { dir:#{$direction}; }', $cp->process('body { dir:ltr; }'));
        $this->assertEquals(self::PREPEND_RULES . 'body { dir:#{$direction_upside}; }', $cp->process('body { dir:rtl; }'));

        $this->assertEquals(self::PREPEND_RULES . 'body[dir="#{$direction}"] {...}', $cp->process('body[dir="ltr"] {...}'));
        $this->assertEquals(self::PREPEND_RULES . 'body[dir="#{$direction_upside}"]', $cp->process('body[dir="rtl"]'));

        $this->assertEquals(self::PREPEND_RULES . 'wordwith:ltrinit;', $cp->process('wordwith:ltrinit;'));
        $this->assertEquals(self::PREPEND_RULES . 'wordwithrtlinit', $cp->process('wordwithrtlinit'));

    }

    public function testTransformAngles()
    {

        $cp = new LiquidSassProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'translate(#{$direction_angle}*-1px,5px)', $cp->process('translate(-1px,5px)'));
        $this->assertEquals(self::PREPEND_RULES . "translate \n( #{\$direction_angle}*12% , 5px )", $cp->process("translate \n( 12% , 5px )"));
        $this->assertEquals(self::PREPEND_RULES . 'translate ( #{$direction_angle}*+12% , -5px )', $cp->process('translate ( +12% , -5px )'));
        $this->assertEquals(self::PREPEND_RULES . 'translate ( #{$direction_angle}*function(1+5) , -5px )', $cp->process('translate ( function(1+5) , -5px )'));

        $this->assertEquals(self::PREPEND_RULES . 'translateX(#{$direction_angle}*-1px)', $cp->process('translateX(-1px)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(#{$direction_angle}*-1%)', $cp->process('translateX(-1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(#{$direction_angle}*1rem)', $cp->process('translateX(1rem)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(#{$direction_angle}*1%)', $cp->process('translateX(1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translateX(#{$direction_angle}*function())', $cp->process('translateX(function())'));

        $this->assertEquals(self::PREPEND_RULES . 'translate3d(#{$direction_angle}*-1px,5px,1%)', $cp->process('translate3d(-1px,5px,1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate3d(#{$direction_angle}*1px,5px,1%)', $cp->process('translate3d(1px,5px,1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate3d(#{$direction_angle}*+1px,5px,1%)', $cp->process('translate3d(+1px,5px,1%)'));
        $this->assertEquals(self::PREPEND_RULES . 'translate3d(#{$direction_angle}*1-function()*3,5px,function2())', $cp->process('translate3d(1-function()*3,5px,function2())'));
    }

    public function testTransformRules()
    {

        $cp = new LiquidSassProcessor();

        $this->assertEquals(self::PREPEND_RULES . 'body {float:#{$direction_start};}', $cp->process('body {float:left;}'));
        $this->assertEquals(self::PREPEND_RULES . 'body {float:#{$direction_end};}', $cp->process('body {float:right;}'));

        $this->assertEquals(self::PREPEND_RULES . '.left {float:#{$direction_start};}', $cp->process('.left {float:left;}'));
        $this->assertEquals(self::PREPEND_RULES . '.right {float:#{$direction_end};}', $cp->process('.right {float:right;}'));

        $this->assertEquals(self::PREPEND_RULES . '.left-body {#{$direction_start}:$left;}', $cp->process('.left-body {left:$left;}'));
        $this->assertEquals(self::PREPEND_RULES . '.right-body {  #{$direction_end}  :  $right ; }', $cp->process('.right-body {  right  :  $right ; }'));

    }


    public function testPrependRules()
    {
        $this->assertEquals(self::PREPEND_RULES, (new LiquidSassProcessor())->process(''));
    }
}
