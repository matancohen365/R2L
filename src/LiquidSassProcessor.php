<?php

namespace AutoRTL;

class LiquidSassProcessor extends CSSProcessor
{
    const DIRECTION_VAR_NAME = '#{$direction}';

    const DIRECTION_UPSIDE_VAR_NAME = '#{$direction_upside}';

    const DIRECTION_START_VAR_NAME = '#{$direction_start}';

    const DIRECTION_END_VAR_NAME = '#{$direction_end}';

    const DIRECTION_ANGLE = '#{$direction_angle}';

    const DIRECTION_UPSIDE_ANGLE = '#{$direction_upside_angle}';

    const VARS_PATTERN = '#\$[a-z0-9_-]+#ixu';

    const TEMP_START_REPLACEMENT = '24020DF9233';

    const TEMP_END_REPLACEMENT = 'C5DE7B08D23';

    const PREPEND_PROPERTIES = '$direction: rtl;
$direction_upside: ltr;
$direction_angle: \'-\';
$direction_upside_angle: \'+\';
$direction_start: right;
$direction_end: left;

@if $direction == ltr {
	$direction_upside: rtl;
	$direction_angle: \'+\';
    $direction_upside_angle: \'-\';
	$direction_start: left;
	$direction_end: right;
}

body {
	direction: $direction;
}' . PHP_EOL;

    public function process(string $contents): string
    {
        $contents = $this->encryptVars($contents);

        $contents = parent::process($contents);

        $contents = $this->decryptVars($contents);

        return $contents;
    }

    protected function encryptVars(string $contents): string
    {
        return preg_replace_callback(
            static::VARS_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::DIRECTION_END, static::DIRECTION_START,],
                    [static::TEMP_END_REPLACEMENT, static::TEMP_START_REPLACEMENT,],
                    $matches[0]
                );
            },
            $contents
        );
    }

    protected function decryptVars(string $contents): string
    {
        return str_ireplace(
            [static::TEMP_END_REPLACEMENT, static::TEMP_START_REPLACEMENT,],
            [static::DIRECTION_END, static::DIRECTION_START,],
            $contents
        );
    }

    protected function processDirection(string $contents): string
    {
        return preg_replace_callback(
            static::DIRECTION_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::UPSIDE_DIRECTION, static::DIRECTION,],
                    [static::DIRECTION_VAR_NAME, static::DIRECTION_UPSIDE_VAR_NAME,],
                    $matches[0]
                );
            },
            $contents
        );
    }

    protected function processValues(string $contents): string
    {
        return preg_replace_callback(
            static::PROPERTY_RULE_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::DIRECTION_START, static::DIRECTION_END,],
                    [static::DIRECTION_END_VAR_NAME, static::DIRECTION_START_VAR_NAME,],
                    $matches[0]
                );
            },
            $contents
        );
    }

}