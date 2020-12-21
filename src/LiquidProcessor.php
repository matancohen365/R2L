<?php

namespace R2L;

/**
 * Class LiquidProcessor
 *
 * @package R2L
 */
class LiquidProcessor implements ProcessorInterface
{
    /**
     * @var ProcessorInterface $next
     */
    protected ProcessorInterface $next;

    /**
     * @param ProcessorInterface $next
     */
    public function __construct(ProcessorInterface $next)
    {
        $this->next = $next;
    }

    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        $masks = [];

        $contents = $this->mask($contents, $masks);

        $contents = $this->next->process($contents);

        $contents = $this->unmask($contents, $masks);

        return $contents;
    }

    /**
     * @param string $contents
     * @param ?array $masks
     * @return string
     */
    protected function mask(string $contents, array &$masks = []): string
    {

        return preg_replace_callback('/{[{%].*[}%]}/ixuU', function ($matches) use (&$masks) {

            return $masks[$matches[0]] = md5($matches[0]);

        }, $contents);

    }

    /**
     * @param string $contents
     * @param array $masks
     * @return string
     */
    protected function unmask(string $contents, array $masks = []): string
    {
        return str_ireplace(array_values($masks), array_keys($masks), $contents);
    }
}
