<?php

namespace R2L;

/**
 * Class HTMLProcessor
 *
 * @package R2L
 */
class HTMLProcessor implements ProcessorInterface
{
    protected CSSProcessor $styleProcessor;

    /**
     * HTMLProcessor constructor.
     *
     * @param CSSProcessor|null $styleProcessor
     */
    public function __construct(CSSProcessor $styleProcessor = null)
    {
        $this->styleProcessor = $styleProcessor ?? new CSSProcessor('');
    }

    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        $contents = preg_replace_callback('/<html[^>]*>/ixu', function ($matches) {

            $contents = preg_replace('/dir\s*=([\'"])ltr([\'"])/ixu', 'dir=$1rtl$2', $matches[0], 1, $count);

            if ($count === 0) {

                return str_replace('>', ' dir="rtl">', $matches[0]);

            }

            return $contents;

        }, $contents);

        $contents = preg_replace_callback(['/(<style[^>]*>)(.*)(<\/style>)/ixu', '/(style\s*=\s*[\'"])([^\'"]+)([\'"])/ixu'], function ($matches) {

            return $matches[1] . $this->getStyleProcessor()->process($matches[2]) . $matches[3];

        }, $contents);


        return $contents;
    }

    /**
     * @return CSSProcessor
     */
    public function getStyleProcessor(): CSSProcessor
    {
        return $this->styleProcessor;
    }
}
