<?php

namespace R2L;

class EmptyProcessor implements ProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return $contents;
    }
}
