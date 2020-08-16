<?php

namespace AutoRTL;

class CSSProcessor implements ProcessorInterface
{
    const DIRECTION = 'rtl';
    const UPSIDE_DIRECTION = 'ltr';
    const DIRECTION_START = 'right';
    const DIRECTION_END = 'left';
    const TEMP_REPLACEMENT = '4D63EC1AA4C';
    const TRANSLATE_PATTERN = '#(translate(|X|3d)\s*\(\s*)([^\s])#ixU';
    const VALUE_PATTERN = '[a-z0-9_\-\.\%\$]+|.+\(.+\)';
    const MARGIN_PADDING_PATTERN = "#(margin|padding)\s*:\s*(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s*(!important)*\s*;#ixu";
    const MARGIN_PADDING_REPLACEMENT = "\\1-top: \\2 \\6;\n\\1-right: \\3 \\6;\n\\1-bottom: \\4 \\6;\n\\1-left: \\5 \\6;\n";
    const BORDER_RADIUS_PATTERN = "#border-radius\s*:\s*(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s+(" . self::VALUE_PATTERN . ")\s*(!important)*\s*;#ixU";
    const BORDER_RADIUS_REPLACEMENT = "border-top-left-radius: \\1 \\5;\nborder-top-right-radius: \\2 \\5;\nborder-bottom-right-radius: \\3 \\5;\nborder-bottom-left-radius: \\4 \\5;\n";
    const DIRECTION_PATTERN = '#(\b)(rtl|ltr)(\b)#ixu';
    const RULES_PATTERN = '#\b(' . self::DIRECTION_END . '|' . self::DIRECTION_START . ')[^{]*[:;]#ixU';

    const PREPEND_RULES = "body { direction: " . self::DIRECTION . " ; }" . PHP_EOL;

    public function process(string $contents): string
    {
        $contents = $this->transformMarginPaddingBorders($contents);

        $contents = $this->transformDirection($contents);

        $contents = $this->transformAngles($contents);

        $contents = $this->transformRules($contents);

        $contents = $this->prependRules($contents);

        return $contents;
    }

    protected function transformMarginPaddingBorders(string $contents): string
    {
        return preg_replace(
            [static::MARGIN_PADDING_PATTERN, static::BORDER_RADIUS_PATTERN,],
            [static::MARGIN_PADDING_REPLACEMENT, static::BORDER_RADIUS_REPLACEMENT,],
            $contents
        );
    }

    protected function transformDirection(string $contents): string
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

    protected function transformAngles(string $contents): string
    {
        return preg_replace_callback(static::TRANSLATE_PATTERN, function ($matches) {

            $prefix = $matches[3] === '-' ? '' : ($matches[3] === '+' ? '-' : "-${matches[3]}");

            return sprintf('%s%s', $matches[1], $prefix);

        }, $contents);
    }

    protected function transformRules(string $contents): string
    {
        return preg_replace_callback(
            static::RULES_PATTERN,
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

    protected function prependRules(string $contents): string
    {
        return static::PREPEND_RULES . $contents;
    }

    private static function d()
    {

        require __DIR__ . '/vendor/autoload.php';

        // css files

        $CSSProcessor = new \AutoRTL\CSSProcessor();

        $CSSContents = file_get_contents('path/to/theme.css');

        $CSSNewContents = $CSSProcessor->process($CSSContents);

        file_put_contents('path/to/theme.rtl.css', $CSSNewContents);

        // liquid.sass files

        $LiquidSassProcessor = new \AutoRTL\LiquidSassProcessor();

        $LiquidSassContents = file_get_contents('path/to/theme.liquid.sass');

        $LiquidSassNewContents = $LiquidSassProcessor->process($LiquidSassContents);

        file_put_contents('path/to/theme.rtl.liquid.sass', $LiquidSassNewContents);

    }

}