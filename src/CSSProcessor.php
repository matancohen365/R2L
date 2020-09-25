<?php

namespace AutoRTL;

class CSSProcessor implements ProcessorInterface
{
    const DIRECTION = 'rtl';

    const UPSIDE_DIRECTION = 'ltr';

    const DIRECTION_START = 'right';

    const DIRECTION_END = 'left';

    const TRANSLATE_PATTERN = '#(?P<function>translate(|X|3d)\s*\(\s*)(?P<argument>[^\s])#ixuU';

    const DIRECTION_PATTERN = '#\b(rtl|ltr)\b#ixu';

    const PROPERTY_RULE_PATTERN = '#\b(' . self::DIRECTION_END . '|' . self::DIRECTION_START . ')[^{]*[:;]#ixuU';

    const PROPERTY_RULES_SET_PATTERN = "#(?P<property>margin|padding|border-radius)\s*:\s*(?P<rule>[^;}]+)#ixu";

    const MARGIN_PADDING_FORMAT = '%1$s-top: %%s; %1$s-%2$s: %%s; %1$s-bottom: %%s; %1$s-%3$s: %%s';

    const BORDER_RADIUS_FORMAT = 'border-top-%2$s-radius: %%s; border-top-%1$s-radius: %%s; border-bottom-%1$s-radius: %%s; border-bottom-%2$s-radius: %%s';

    const TEMP_REPLACEMENT = '4D63EC1AA4C';

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
        return preg_replace_callback(static::PROPERTY_RULES_SET_PATTERN, function ($matches) {

            $rule = preg_replace('/\s*!important\s*?/ixu', '', trim($matches['rule']), 1, $important);

            $ruleSet = $this->parseRuleSet($rule);

            if (count($ruleSet) <= 3) {
                return sprintf('%s:%s', $matches['property'], $matches['rule']);
            }

            $format = $matches['property'] === 'border-radius'
                ? sprintf(static::BORDER_RADIUS_FORMAT, static::DIRECTION_START, static::DIRECTION_END)
                : sprintf(static::MARGIN_PADDING_FORMAT, $matches['property'], static::DIRECTION_START, static::DIRECTION_END);

            return sprintf($format, ...array_map(function ($rule) use ($important) {

                if ($important === 1) {

                    $rule = $rule . ' !important';

                }

                return $rule;

            }, $ruleSet));

        }, $contents);
    }

    /**
     * @param string $rule
     * @return array
     */
    private function parseRuleSet(string $rule): array
    {
        $ruleSet = [];

        while (strlen($rule) > 0) {

            $value = '';

            while (strlen($value) !== strlen($rule) &&
                (substr_count($value, '(',) !== substr_count($value, ')',) || substr($value, -1) !== ' ')) {
                $value = substr($rule, 0, strlen($value) + 1);
            }

            $rule = substr($rule, strlen($value));

            $ruleSet[] = trim($value);
        }

        return $ruleSet;
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
            static::PROPERTY_RULE_PATTERN,
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