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
     * @param string|null $value Default value.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly ?string $value = null
    )
    {}

    /**
     * Factory method.
     *
     * @param string $name
     * @param string $label
     * @param string|null $value
     *
     * @return self
     */
    public static function create(string $name, string $label, ?string $value = ''): self
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
        return !empty($this->value);
    }
}
