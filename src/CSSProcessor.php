<?php

namespace AutoRTL;

class CSSProcessor implements ProcessorInterface
{
    const DIRECTION = 'rtl';

    const UPSIDE_DIRECTION = 'ltr';

    const DIRECTION_START = 'right';

    const DIRECTION_END = 'left';

    const TRANSLATE_PATTERN = '#(?P<function>translate(|X|3d)\s*\(\s*)(?P<argument>[^\s])#ixuU';

    const VALUE_PATTERN = '[a-z0-9_\-\.\%\$]+|.+\(.+\)';

    const DIRECTION_PATTERN = '#\b(rtl|ltr)\b#ixu';

    const PROPERTY_VALUE_PATTERN = '#\b(' . self::DIRECTION_END . '|' . self::DIRECTION_START . ')[^{]*[:;]#ixuU';

    const MARGIN_PADDING_PATTERN =
        "#(margin|padding)\s*:\s*(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN .
        ")\s+(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s*(!important)*\s*;?#ixu";

    const BORDER_RADIUS_PATTERN =
        "#border-radius\s*:\s*(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s+("
        . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s*(!important)*\s*;*#ixu";

    const TEMP_REPLACEMENT = '4D63EC1AA4C';

    const BORDER_RADIUS_REPLACEMENT =
        "border-top-left-radius: \\1 \\5; border-top-right-radius: \\2 \\5; " .
        "border-bottom-right-radius: \\3 \\5; border-bottom-left-radius: \\4 \\5;";

    const MARGIN_PADDING_REPLACEMENT = "\\1-top: \\2 \\6; \\1-right: \\3 \\6; \\1-bottom: \\4 \\6; \\1-left: \\5 \\6;";

    const PREPEND_PROPERTIES = "body { direction: " . self::DIRECTION . " ; }" . PHP_EOL;

    const DIRECTION_ANGLE = '-';
    const DIRECTION_UPSIDE_ANGLE = '+';

    public function process(string $contents): string
    {
        $contents = $this->processMarginPaddingBorders($contents);

        $contents = $this->processDirection($contents);

        $contents = $this->processAngles($contents);

        $contents = $this->processValues($contents);

        $contents = $this->prependProperties($contents);

        return $contents;
    }

    protected function processMarginPaddingBorders(string $contents): string
    {
        return preg_replace(
            [static::MARGIN_PADDING_PATTERN, static::BORDER_RADIUS_PATTERN,],
            [static::MARGIN_PADDING_REPLACEMENT, static::BORDER_RADIUS_REPLACEMENT,],
            $contents
        );
    }

    protected function processDirection(string $contents): string
    {
        return preg_replace_callback(
            static::DIRECTION_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::DIRECTION, static::UPSIDE_DIRECTION, static::TEMP_REPLACEMENT,],
                    [static::TEMP_REPLACEMENT, static::DIRECTION, static::UPSIDE_DIRECTION],
                    $matches[0]
                );
            },
            $contents
        );
    }

    protected function processAngles(string $contents): string
    {
        return preg_replace_callback(static::TRANSLATE_PATTERN, function ($matches) {

            switch (true) {

                case $matches['argument'] === '-':
                    $prefix = static::DIRECTION_UPSIDE_ANGLE;
                    break;

                case $matches['argument'] === '+':
                    $prefix = static::DIRECTION_ANGLE;
                    break;

                default:
                    $prefix = static::DIRECTION_ANGLE . $matches['argument'];
                    break;

            }

            return sprintf('%s%s', $matches['function'], $prefix);

        }, $contents);
    }

    protected function processValues(string $contents): string
    {
        return preg_replace_callback(
            static::PROPERTY_VALUE_PATTERN,
            function ($matches) {
                return str_ireplace(
                    [static::DIRECTION_START, static::DIRECTION_END, static::TEMP_REPLACEMENT,],
                    [static::TEMP_REPLACEMENT, static::DIRECTION_START, static::DIRECTION_END],
                    $matches[0]
                );
            },
            $contents
        );

    }

    protected function prependProperties(string $contents): string
    {
        return static::PREPEND_PROPERTIES . $contents;
    }

}