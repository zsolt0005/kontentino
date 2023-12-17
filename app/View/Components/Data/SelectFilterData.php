<?php declare(strict_types=1);

namespace App\View\Components\Data;

/**
 * Class SelectFilterData
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class SelectFilterData implements IFilterData
{
    /**
     * Constructor.
     *
     * @param string $name Name.
     * @param string $label Label text.
     * @param string|null $selectedValue Default value.
     * @param array<SelectFilterValueData> $values Select values.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $label,
        public readonly ?string $selectedValue,
        public readonly array  $values
    )
    {
    }

    /**
     * Factory method.
     *
     * @param string $name
     * @param string $label
     * @param string|null $selectedValue
     * @param array<SelectFilterValueData> $values
     *
     * @return self
     */
    public static function create(string $name, string $label, ?string $selectedValue, array $values): self
    {
        return new self($name, $label, $selectedValue, $values);
    }

    /** @inheritDoc */
    public function getComponentName(): string
    {
        return 'select-filter-component';
    }

    /** @inheritDoc */
    public function isActive(): bool
    {
        return !empty($this->selectedValue);
    }
}
