<?php declare(strict_types = 1);

namespace App\Services;

use App\Data\PeopleResponseData;
use App\Data\PlanetsResponseData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use Spatie\LaravelData\Contracts\BaseData;

/**
 * This class provides methods to fetch Star Wars API (SWAPI) data.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class SwapiService
{
    /** @var string API Url to fetch a list of people. */
    private const PEOPLE_URL = 'https://swapi.py4e.com/api/people/';

    /** @var string API Url to fetch a list of planets. */
    private const PLANETS_URL = 'https://swapi.py4e.com/api/planets/';

    /**
     * Fetch residents by page number.
     *
     * @param int $page The page number to fetch residents from.
     * @return PeopleResponseData
     * @throws GuzzleException If an error occurs while making the HTTP request.
     * @throws RuntimeException
     */
    public function fetchPeopleByPage(int $page): PeopleResponseData
    {
        return $this->fetchData(self::PEOPLE_URL . '?page=' . $page, PeopleResponseData::class);
    }

    /**
     * Fetch planets by page number.
     *
     * @param int $page The page number to fetch planets from.
     * @return PlanetsResponseData
     * @throws GuzzleException If an error occurs while making the HTTP request.
     * @throws RuntimeException
     */
    public function fetchPlanetsByPage(int $page): PlanetsResponseData
    {
        return $this->fetchData(self::PLANETS_URL . '?page=' . $page, PlanetsResponseData::class);
    }

    /**
     * Fetch data from the provided URL.
     *
     * @template T of BaseData
     *
     * @param string $url The URL to fetch data from.
     * @param class-string<T> $dtoClass
     * @return T The parsed array of data fetched from the URL.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     * @throws RuntimeException
     */
    private function fetchData(string $url, string $dtoClass): BaseData
    {
        $client = new Client();

        $response = $client->get($url);
        $body = $response->getBody();

        /** @var array<mixed> $parsedBody */
        $parsedBody = json_decode($body->getContents(), true);

        return $dtoClass::from($parsedBody);
    }
}
