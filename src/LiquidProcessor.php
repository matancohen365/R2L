<?php

namespace R2L;

/**
 * Class LiquidProcessor
 *
 * @package R2L
 */
class LiquidProcessor implements ProcessorInterface
{
    use ProcessorMask;

    /**
     * @inheritdoc
     */
    function getMaskREGEX(): string
    {
        return '/{[{%].*[}%]}/ixuU';
    }
}
