<?php

namespace AutoRTL;

require_once 'AbstractProcessorTest.php';

class LiquidSassProcessorTest extends AbstractProcessorTest
{

    static public function getProcessor(): ProcessorInterface
    {
        return new LiquidSassProcessor();
    }

    public function testTransformMarginPaddingBorders()
    {
        static::assertResults('padding:1px;', 'padding:1px;');

        static::assertResults('padding:1px 2px;', 'padding:1px 2px;');

        static::assertResults('padding:1px 2px 3px;', 'padding:1px 2px 3px;');

        static::assertResults('padding:1px 2% 3px 4rem;',
            'padding-top: 1px; padding-#{$direction_end}: 2%; padding-bottom: 3px; padding-#{$direction_start}: 4rem;');

        static::assertResults('padding:1px 2% 3px 4rem !important;',
            'padding-top: 1px !important; padding-#{$direction_end}: 2% !important; padding-bottom: 3px !important; padding-#{$direction_start}: 4rem !important;');

        static::assertResults('padding: ($A) ($B) ($C) (($D) - $D2);',
            'padding-top: ($A); padding-#{$direction_end}: ($B); padding-bottom: ($C); padding-#{$direction_start}: (($D) - $D2);');

        static::assertResults('padding: ($A) ($B) ($C) (($D) - $D2) !important;',
            'padding-top: ($A) !important; padding-#{$direction_end}: ($B) !important; padding-bottom: ($C) !important; padding-#{$direction_start}: (($D) - $D2) !important;');

        static::assertResults('margin:1px;', 'margin:1px;');

        static::assertResults('margin:1px 2px;', 'margin:1px 2px;');

        static::assertResults('margin:1px 2px 3px;', 'margin:1px 2px 3px;');

        static::assertResults('margin:1px 2% 3px 4rem;',
            'margin-top: 1px; margin-#{$direction_end}: 2%; margin-bottom: 3px; margin-#{$direction_start}: 4rem;');

        static::assertResults('margin:1px function(2+5*3, 23) $var 4rem !important;',
            'margin-top: 1px !important; margin-#{$direction_end}: function(2+5*3, 23) !important; margin-bottom: $var !important; margin-#{$direction_start}: 4rem !important;');

        static::assertResults('border-radius:1px;', 'border-radius:1px;');

        static::assertResults('border-radius:1px 2px;', 'border-radius:1px 2px;');

        static::assertResults('border-radius:1px 2px 3px;', 'border-radius:1px 2px 3px;');

        static::assertResults('border-radius:1px 2% 3px 4rem;',
            'border-top-#{$direction_start}-radius: 1px; border-top-#{$direction_end}-radius: 2%; border-bottom-#{$direction_end}-radius: 3px; border-bottom-#{$direction_start}-radius: 4rem;');

        static::assertResults('border-radius:1px 2% 3px 4rem !important;',
            'border-top-#{$direction_start}-radius: 1px !important; border-top-#{$direction_end}-radius: 2% !important; border-bottom-#{$direction_end}-radius: 3px !important; border-bottom-#{$direction_start}-radius: 4rem !important;');

        static::assertResults('margin: 0 ($gutter / 4) ($gutter / 4);', 'margin:0 ($gutter / 4) ($gutter / 4);');

        static::assertResults('padding:1px $var * 1;', 'padding:1px $var * 1;');

        static::assertResults('padding:1px $var*1 1% 1rem;', 'padding-top: 1px; padding-#{$direction_end}: $var*1; padding-bottom: 1%; padding-#{$direction_start}: 1rem;');
    }

    public function testTransformDirection()
    {
        static::assertResults('body { dir:ltr; }', 'body { dir:#{$direction}; }');

        static::assertResults('body { dir:rtl; }', 'body { dir:#{$direction_upside}; }');

        static::assertResults('body[dir="ltr"] {...}', 'body[dir="#{$direction}"] {...}');

        static::assertResults('body[dir="rtl"]', 'body[dir="#{$direction_upside}"]');

        static::assertResults('wordwith:ltrinit;', 'wordwith:ltrinit;');

        static::assertResults('wordwithrtlinit', 'wordwithrtlinit');
    }

    public function testTransformAngles()
    {
        static::assertResults('translate(-1px,5px)', 'translate(#{$direction_upside_angle}1px,5px)');

        static::assertResults('translate ( 12% , 5px )', 'translate ( #{$direction_angle}12% , 5px )');

        static::assertResults('translate ( +12% , -5px )', 'translate ( #{$direction_angle}12% , -5px )');

        static::assertResults('translateX(-1px)', 'translateX(#{$direction_upside_angle}1px)');

        static::assertResults('translateX(-1%)', 'translateX(#{$direction_upside_angle}1%)');

        static::assertResults('translateX(1rem)', 'translateX(#{$direction_angle}1rem)');

        static::assertResults('translateX(1%)', 'translateX(#{$direction_angle}1%)');

        static::assertResults('translate3d(-1px,5px,1%)', 'translate3d(#{$direction_upside_angle}1px,5px,1%)');

        static::assertResults('translate3d(1px,5px,1%)', 'translate3d(#{$direction_angle}1px,5px,1%)');

        static::assertResults('translate3d(+1px,5px,1%)', 'translate3d(#{$direction_angle}1px,5px,1%)');
    }

    public function testTransformRules()
    {
        static::assertResults('body {float:left;}', 'body {float:#{$direction_start};}');

        static::assertResults('body {float:right;}', 'body {float:#{$direction_end};}');

        static::assertResults('.left {float:left;}', '.left {float:#{$direction_start};}');

        static::assertResults('.right {float:right;}', '.right {float:#{$direction_end};}');

        static::assertResults('.left-body {left:$left;}', '.left-body {#{$direction_start}:$left;}');

        static::assertResults('.right-body {  right  :  $right; }', '.right-body {  #{$direction_end}  :  $right; }');
    }
}
