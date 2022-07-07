<?php

namespace Guess\Infrastructure\RapidApi;

use DateTimeImmutable;
use Exception;
use Guess\Infrastructure\Services\ProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;

class RapidApiClient implements ProviderInterface
{
    
    //https://api-football-v1.p.rapidapi.com/v2/leagues/season/2020
    //https://api-football-v1.p.rapidapi.com/v2/teams/league/
    //https://api-football-v1.p.rapidapi.com/v2/fixtures/date/

    const API_FOOTBALL_URI_LEAGUES = 'https://api-football-v1.p.rapidapi.com/v2/leagues/season/2020';
    const API_FOOTBALL_URI_TEAMS = 'https://api-football-v1.p.rapidapi.com/v2/teams/league/';
    const API_FOOTBALL_URI_GAMES = 'https://api-football-v1.p.rapidapi.com/v2/fixtures/date/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            ['headers' =>
                ['X-RapidAPI-Key' => '8e3c4f1fdbmsh49dd3c8005e07d2p10c71ejsn58dad357d065',
                'X-RapidAPI-Host' =>'api-football-v1.p.rapidapi.com']]
        );
    }

    /**
     * @param array $criteria
     * @return array|bool|float|int|object|string|null
     * @throws GuzzleException
     * @throws Exception
     */
    public function getContent(array $criteria): float|object|int|bool|array|string|null
    {
        $response = "";

        if (!$criteria) {
            $response = $this->client->request(
                'GET',
                self::API_FOOTBALL_URI_LEAGUES
            );
        }

        if (isset($criteria['league-api-id'])) {
            $response = $this->client->request(
                'GET',
                self::API_FOOTBALL_URI_TEAMS.$criteria['league-api-id']
            );
        }

        if (isset($criteria['days'])) {
            $response = $this->client->request(
                'GET',
                self::API_FOOTBALL_URI_GAMES.
                (new DateTimeImmutable($criteria['days'] . " day"))
                    ->format('Y-m-d')
            );
        }

        return Utils::jsonDecode(
            $response->getBody()->getContents(), true
        );
    }
}