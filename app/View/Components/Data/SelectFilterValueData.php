<?php declare(strict_types=1);

namespace App\View\Components\Data;

/**
 * Class SelectFilterData
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class SelectFilterValueData
{
    /**
     * Constructor.
     *
     * @param string $key
     * @param string $value
     */
    public function __construct(
        public string $key,
        public string $value
    )
    {}

    /**
     * Factory method.
     *
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public static function create(string $key, string $value): self
    {
        return new self($key, $value);
    }

    /**
     * Creates an empty value.
     *
     * @return self
     */
    public static function empty(): self
    {
        return new self('', '');
    }
}
