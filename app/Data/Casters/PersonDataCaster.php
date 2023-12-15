<?php declare(strict_types=1);

namespace App\Data\Casters;

use App\Data\PersonData;
use App\Data\PlanetData;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * Casts an array to an array<PersonData>.
 *
 * @package App\Data\Casters
 * @author  Zsolt Döme
 * @since   2023
 */
final class PersonDataCaster implements Caster
{
    /**
     * Casts the given value into an array of PersonData objects.
     *
     * @param mixed $value The value to be cast. It can be of any type.
     * @return array<PersonData> An array of PersonData objects.
     * @throws UnknownProperties If the given value is not an array.
     */
    public function cast(mixed $value): array
    {
        return array_map(static fn(array $data) => new PersonData($data), $value);
    }
}
