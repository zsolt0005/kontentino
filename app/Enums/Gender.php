<?php declare(strict_types = 1);

namespace App\Enums;

/**
 * Represents the gender of an individual.
 *
 * @package App\Enums
 * @author  Zsolt Döme
 * @since   2023
 */
enum Gender: string
{
    case FEMALE = 'female';
    case MALE = 'male';
    case HERMAPHRODITE = 'hermaphrodite';
    case UNKNOWN = 'unknown';
    case NONE = 'n/a';
}
