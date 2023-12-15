<?php

namespace App\Data;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Represents person data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PersonData extends DataTransferObject
{
	public string $name;

	public string $height;

	public string $mass;

    #[MapFrom('hair_color')]
	public string $hairColor;

    #[MapFrom('skin_color')]
	public string $skinColor;

    #[MapFrom('eye_color')]
	public string $eyeColor;

    #[MapFrom('birth_year')]
	public string $birthYear;

	public string $gender;

    #[MapFrom('homeworld')]
	public string $homeWorldUrl;

    #[MapFrom('created')]
	public string $createdAt;

    #[MapFrom('edited')]
	public string $editedAt;

	public string $url;
}
