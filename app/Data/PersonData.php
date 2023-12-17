<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

/**
 * Represents person data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PersonData extends Data
{
	public string $name;

	public string $height;

	public string $mass;

    #[MapName('hair_color')]
	public string $hairColor;

    #[MapName('skin_color')]
	public string $skinColor;

    #[MapName('eye_color')]
	public string $eyeColor;

    #[MapName('birth_year')]
	public string $birthYear;

	public string $gender;

    #[MapName('homeworld')]
	public string $homeWorldUrl;

    #[MapName('created')]
	public string $createdAt;

    #[MapName('edited')]
	public string $editedAt;

	public string $url;
}
