<?php

namespace R2L;

class HTMLProcessor implements ProcessorInterface
{
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

            return $matches[1] . (new CSSProcessor(''))->process($matches[2]) . $matches[3];

        }, $contents);


        return $contents;
    }
}
