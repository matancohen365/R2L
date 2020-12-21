<?php

namespace R2L;

/**
 * Class SassProcessor
 *
 * @package R2L
 */
class SassProcessor extends CSSProcessor
{
    const DIRECTION_VAR_NAME = '#{$direction}';

    const DIRECTION_UPSIDE_VAR_NAME = '#{$direction_upside}';

    const DIRECTION_START_VAR_NAME = '#{$direction_start}';

    const DIRECTION_END_VAR_NAME = '#{$direction_end}';

    const DIRECTION_ANGLE = '#{$direction_angle}';

    const DIRECTION_UPSIDE_ANGLE = '#{$direction_upside_angle}';

    const VARS_PATTERN = '#\$[a-z0-9_-]+#ixu';

    const NUMERIC_OPERATORS_PATTERN = '#\s+[\*\-\+\/\%]\s+#ixu';

    const TEMP_START_REPLACEMENT = '24020DF9233';

    const TEMP_END_REPLACEMENT = 'C5DE7B08D23';

    const TEMP_SPACE_REPLACEMENT = 'GERT12E1S2A';

    const DEFAULT_PROPERTIES = '$direction: rtl;
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

    const SPACE = ' ';

    /**
     * CSSProcessor constructor.
     * @param string $properties
     */
    public function __construct(string $properties = self::DEFAULT_PROPERTIES)
    {
        parent::__construct($properties);
    }

    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        $contents = $this->mask($contents);

        $contents = parent::process($contents);

        $contents = $this->unmask($contents);

        return $contents;
    }

    /**
     * @param string $contents
     * @return string
     */
    protected function mask(string $contents): string
    {
        $contents = preg_replace_callback(
            static::NUMERIC_OPERATORS_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::SPACE],
                    [static::TEMP_SPACE_REPLACEMENT],
                    $matches[0],
                );
            },
            $contents
        );

        $contents = preg_replace_callback(
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

        return $contents;
    }

    /**
     * @param string $contents
     * @return string
     */
    protected function unmask(string $contents): string
    {
        return str_ireplace(
            [static::TEMP_SPACE_REPLACEMENT, static::TEMP_END_REPLACEMENT, static::TEMP_START_REPLACEMENT,],
            [static::SPACE, static::DIRECTION_END, static::DIRECTION_START,],
            $contents
        );
    }

    /**
     * @param string $contents
     * @return string
     */
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

    /**
     * @param string $contents
     * @return string
     */
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