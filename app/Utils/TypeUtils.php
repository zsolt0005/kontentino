<?php declare(strict_types=1);

namespace App\Utils;

/**
 * Type utils.
 *
 * @package App\Utils
 * @author  Zsolt Döme
 * @since   2023
 */
final class TypeUtils
{
    /** Constructor. */
    private function __construct(){}

    /**
     * Converts a value to int, if null, returns null.
     *
     * @param mixed|null $input
     *
     * @return int|null
     */
    public static function convertToInt(mixed $input): ?int
    {
        return ($input === null) ? null : (int) $input;
    }
}
