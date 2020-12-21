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
        return str_ireplace('rtl:!1', 'rtl:true', $contents);
    }
}
