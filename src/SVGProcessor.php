<?php

namespace R2L;

/**
 * Class SVGProcessor
 *
 * @package R2L
 * @deprecated
 */
class SVGProcessor implements ProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return preg_replace_callback('/<svg[^>]*>/ixu', function ($matches) {

            $contents = preg_replace('/transform\s*=([\'"])(.*)([\'"])/ixu', 'transform=$1$2 rotate(180) $3', $matches[0], 1, $count);

            if ($count === 0) {

                return str_replace('>', ' transform="rotate(180)">', $matches[0]);

            }

            return $contents;

        }, $contents);
    }
}
