<?php declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * @return array<string, mixed> The array of residents fetched. For the schema see {@see https://swapi.py4e.com/documentation#people}.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     */
    public function fetchPeopleByPage(int $page): array
    {
        return $this->fetchData(self::PEOPLE_URL . '?page=' . $page);
    }

    /**
     * Fetch planets by page number.
     *
     * @param int $page The page number to fetch planets from.
     * @return array<string, mixed> The array of planets fetched. For the schema see {@see https://swapi.py4e.com/documentation#planets}.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     */
    public function fetchPlanetsByPage(int $page): array
    {
        return $this->fetchData(self::PLANETS_URL . '?page=' . $page);
    }

    /**
     * Fetch data from the provided URL.
     *
     * @param string $url The URL to fetch data from.
     * @return array<mixed> The parsed array of data fetched from the URL.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     */
    private function fetchData(string $url): array
    {
        $client = new Client();

        $response = $client->get($url);
        $body = $response->getBody();

        /** @var array<mixed> $parsedBody */
        $parsedBody = json_decode($body->getContents(), true);

        return $parsedBody;
    }
}
