<?php declare(strict_types=1);

namespace App\View\Components\Data;

/**
 * Class TextFilterData
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class TextFilterData implements IFilterData
{
    /**
     * Constructor.
     *
     * @param string $name Name.
     * @param string $label Label text.
     * @param string $value Default value.
     */
    public function __construct(
        public string $name,
        public string $label,
        public string $value = ''
    )
    {}

    /**
     * Factory method.
     *
     * @param string $name
     * @param string $label
     * @param string $value
     *
     * @return self
     */
    public static function create(string $name, string $label, string $value = ''): self
    {
        return new self($name, $label, $value);
    }

    /** @inheritDoc */
    public function getComponentName(): string
    {
        return 'text-filter-component';
    }

    /** @inheritDoc */
    public function isActive(): bool
    {
        return $this->value !== '';
    }
}
