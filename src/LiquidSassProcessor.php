<?php

namespace AutoRTL;

class LiquidSassProcessor extends CSSProcessor
{
    const DIRECTION_VAR_NAME = '#{$direction}';
    const DIRECTION_UPSIDE_VAR_NAME = '#{$direction_upside}';
    const DIRECTION_START_VAR_NAME = '#{$direction_start}';
    const DIRECTION_END_VAR_NAME = '#{$direction_end}';
    const DIRECTION_ANGLE_VAR_NAME = '#{$direction_angle}';
    const VARS_PATTERN = '#(\$[a-z0-9_-]+)#ixu';
    const VARS_START_REPLACEMENT = '24020DF9233';
    const VARS_END_REPLACEMENT = 'C5DE7B08D23';

    public const PREPEND_RULES = '$direction: rtl;
$direction_upside: ltr;
$direction_angle: -1;
$direction_start: right;
$direction_end: left;

@if $direction == ltr {
	$direction_upside: rtl;
	$direction_angle: 1;
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
                    [static::VARS_END_REPLACEMENT, static::VARS_START_REPLACEMENT,],
                    $matches[0]
                );
            },
            $contents
        );
    }

    protected function decryptVars(string $contents): string
    {
        return str_ireplace(
            [static::VARS_END_REPLACEMENT, static::VARS_START_REPLACEMENT,],
            [static::DIRECTION_END, static::DIRECTION_START,],
            $contents
        );
    }

    protected function transformDirection(string $contents): string
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

    protected function transformAngles(string $contents): string
    {
        return preg_replace_callback(static::TRANSLATE_PATTERN, function ($matches) {
            return sprintf('%s%s*%s', $matches[1], static::DIRECTION_ANGLE_VAR_NAME, $matches[3]);
        }, $contents);
    }

    protected function transformRules(string $contents): string
    {
        return preg_replace_callback(
            static::RULES_PATTERN,
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