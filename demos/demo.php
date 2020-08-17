<?php

use AutoRTL\CSSProcessor;
use AutoRTL\LiquidSassProcessor;

require __DIR__ . '../vendor/autoload.php';

/// .css

$processor = new CSSProcessor();

$contents = file_get_contents(__DIR__ . '/theme.css');

$RTLContents = $processor->process($contents);

file_put_contents(__DIR__ . '/theme.rtl.css', $RTLContents);


/// .scss.liquid

$processor = new LiquidSassProcessor();

$contents = file_get_contents(__DIR__ . '/theme.scss.liquid');

$RTLContents = $processor->process($contents);

file_put_contents(__DIR__ . '/theme.rtl.scss.liquid', $RTLContents);