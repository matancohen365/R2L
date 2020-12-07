<?php

namespace R2L;

use Intervention\Image\ImageManager;

class ImageProcessor implements ProcessorInterface
{
    /**
     * Image output format
     *
     * @var string|null
     */
    private ?string $contentType;

    /**
     * ImageProcessor constructor.
     * @param string|null $contentType
     */
    public function __construct(string $contentType = null)
    {
        $this->contentType = $contentType;
    }

    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return (new ImageManager())->make($contents)->flip()->encode($this->contentType);
    }
}
