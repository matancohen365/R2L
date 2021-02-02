<?php

namespace R2L;

trait ProcessorMask
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
        return preg_replace_callback($this->getMaskREGEX(), function ($matches) use (&$masks) {

            [$key, $value] = [md5($matches[0]), $matches[0]];

            $masks[$key] = $value;

            return $key;

        }, $contents);
    }

    /**
     * @param string $contents
     * @param array $masks
     * @return string
     */
    protected function unmask(string $contents, array $masks = []): string
    {
        return str_ireplace(array_keys($masks), array_values($masks), $contents);
    }

    /**
     * Get the mask regex.
     *
     * @return string
     */
    abstract function getMaskREGEX(): string;

}