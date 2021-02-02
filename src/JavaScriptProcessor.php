<?php

namespace R2L;

/**
 * Class JavaScriptProcessor
 *
 * @package R2L
 */
class JavaScriptProcessor implements ProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return $this->processSlickJS($contents);
    }

    /**
     * Process slick.js
     *
     * @param string $contents
     * @return string
     */
    public function processSlickJS(string $contents): string
    {
        return str_replace('rtl:!1', 'rtl:true', $contents);
    }
}
