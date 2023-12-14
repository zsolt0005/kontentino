<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * @return array The array of residents fetched.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     */
    public function fetchPeopleByPage(int $page): array
    {
        $client = new Client();

        $response = $client->get(self::PEOPLE_URL . '?page=' . $page);
        $body = $response->getBody();

        return json_decode($body->getContents(), true);
    }

    /**
     * Fetch planets by page number.
     *
     * @param int $page The page number to fetch planets from.
     * @return array The array of planets fetched.
     * @throws GuzzleException If an error occurs while making the HTTP request.
     */
    public function fetchPlanetsByPage(int $page): array
    {
        $client = new Client();

        $response = $client->get(self::PLANETS_URL . '?page=' . $page);
        $body = $response->getBody();

        return json_decode($body->getContents(), true);
    }
}
