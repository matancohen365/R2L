<?php

namespace R2L;

class JavaScriptProcessor implements ProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return preg_replace('/rtl:!1/ixu', 'rtl:true', $contents);
    }
}
