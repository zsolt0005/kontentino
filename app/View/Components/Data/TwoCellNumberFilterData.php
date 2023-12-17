<?php declare(strict_types=1);

namespace App\View\Components\Data;

/**
 * Class TwoCellTextFilterData
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class TwoCellNumberFilterData implements IFilterData
{
    /**
     * Constructor.
     *
     * @param string $leftCellName Name of the left cell.
     * @param string $rightCellName Name of the right cell.
     * @param string $label Label text.
     * @param string $leftCellLabel
     * @param string $rightCellLabel
     * @param int|null $leftCellValue Default value for the left cell.
     * @param int|null $rightCellValue Default value for the right cell.
     */
    public function __construct(
        public string $leftCellName,
        public string $rightCellName,
        public string $label,
        public string $leftCellLabel,
        public string $rightCellLabel,
        public ?int $leftCellValue = null,
        public ?int $rightCellValue = null
    )
    {}

    /**
     * Factory method.
     *
     * @param string $leftCellName
     * @param string $rightCellName
     * @param string $label
     * @param string $leftCellLabel
     * @param string $rightCellLabel
     * @param int|null $leftCellValue
     * @param int|null $rightCellValue
     *
     * @return self
     */
    public static function create(
        string $leftCellName,
        string $rightCellName,
        string $label,
        string $leftCellLabel,
        string $rightCellLabel,
        ?int $leftCellValue = null,
        ?int $rightCellValue = null): self
    {
        return new self($leftCellName, $rightCellName, $label, $leftCellLabel, $rightCellLabel, $leftCellValue, $rightCellValue);
    }

    /** @inheritDoc */
    public function getComponentName(): string
    {
        return 'two-cell-number-filter-component';
    }

    /** @inheritDoc */
    public function isActive(): bool
    {
        return $this->leftCellValue !== null && $this->rightCellValue !== null;
    }
}
