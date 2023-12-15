<?php declare(strict_types=1);

namespace App\Data\Casters;

use App\Data\PlanetData;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * Casts an array to an array<PlanetData>
 *
 * @package App\Data\Casters
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetDataCaster implements Caster
{
    /**
     * Casts the given value into an array of PlanetData objects.
     *
     * @param array<array<string, mixed>> $value The value to be cast. It can be of any type.
     * @return array<PlanetData> An array of PlanetData objects.
     * @throws UnknownProperties If the given value is not an array.
     */
    public function cast(mixed $value): array
    {
        return array_map(static fn(array $data) => new PlanetData($data), $value);
    }
}
