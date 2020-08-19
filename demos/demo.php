<?php

use AutoRTL\CSSProcessor;
use AutoRTL\LiquidSassProcessor;

require __DIR__ . '/../vendor/autoload.php';

function getRTLFileName(string $filename): string
{

    $basename = basename($filename);

    $basenameParts = explode('.', $basename);

    $RTLBasename = sprintf('%s.rtl.%s', array_shift($basenameParts), implode('.', $basenameParts));

    return str_ireplace($basename, $RTLBasename, $filename);

}

/// .css

foreach (glob(__DIR__ . '*/*.css') as $file) {

    print $file . PHP_EOL;

    $processor = new CSSProcessor();

    $contents = file_get_contents($file);

    $RTLContents = $processor->process($contents);

    file_put_contents(getRTLFileName($file), $RTLContents);

}

/// .scss.liquid

foreach (glob(__DIR__ . '*/*.scss.liquid') as $file) {

    print $file . PHP_EOL;

    $processor = new LiquidSassProcessor();

    $contents = file_get_contents($file);

    $RTLContents = $processor->process($contents);

    file_put_contents(getRTLFileName($file), $RTLContents);

}

