<?php

namespace R2L;

/**
 * Class LocaleFileProcessor
 *
 * @package R2L
 */
class LocaleFileProcessor implements ProcessorInterface
{
    /**
     * template file contents
     *
     * @var string
     */
    protected string $templateContents;

    /**
     * LocaleFileProcessor constructor.
     * @param string $templateContents
     */
    public function __construct(string $templateContents)
    {
        $this->templateContents = $templateContents;
    }

    /**
     * @inheritdoc
     */
    public function process(string $contents): string
    {
        return $this->toJson(
            $this->mergeTemplateArrays(
                $this->toArray($contents),
                $this->toArray($this->getTemplateContents()),
            )
        );
    }

    /**
     * @param array $array
     * @return string
     */
    protected function toJson(array $array): string
    {
        return json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array
     */
    protected function mergeTemplateArrays(): array
    {
        if (func_num_args() < 2) {
            trigger_error(__FUNCTION__ . ' needs two or more array arguments', E_USER_WARNING);
            return [];
        }
        $arrays = func_get_args();
        $merged = array();
        while ($arrays) {
            $array = array_shift($arrays);
            if (!is_array($array)) {
                trigger_error(__FUNCTION__ . ' encountered a non array argument', E_USER_WARNING);
                return [];
            }
            if (!$array)
                continue;
            foreach ($array as $key => $value)
                if (is_string($key) || is_numeric($key))
                    if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key]))
                        $merged[$key] = call_user_func([$this, __FUNCTION__], $merged[$key], $value);
                    else
                        $merged[$key] = $value;
                else
                    $merged[] = $value;
        }
        return $merged;
    }

    /**
     * @param string $json
     * @return array
     */
    protected function toArray(string $json): array
    {
        return json_decode($json, true, 512, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return string
     */
    public function getTemplateContents(): string
    {
        return $this->templateContents;
    }
}
