<?php declare(strict_types=1);

namespace App\Data;

/**
 * Error data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class ErrorData
{
    /**
     * Constructor.
     *
     * @param string $message
     */
    public function __construct(public readonly string $message)
    {
    }
}
