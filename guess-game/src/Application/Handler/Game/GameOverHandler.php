<?php

namespace Guess\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Guess\Domain\Game\Game;
use Guess\Domain\Game\GameRepositoryInterface;
use Guess\Domain\Team\TeamRepositoryInterface;

class GameOverHandler
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private TeamRepositoryInterface $teamRepository
    )
    {
    }

    /**
     * @param array $gameFromApi
     * @throws Exception
     */
    public function handle(array $gameFromApi) : bool
    {
        // if (!isset($gameFromApi['score'])) {
        //     throw new Exception('Need score to finish the game');
        // }

        $homeTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['awayTeam']]);
        $valid = true;
        // if (!$homeTeam) {
        //     throw new Exception($gameFromApi['homeTeam']. ' is not the part of our database');
        // }

        // if (!$awayTeam) {
        //     throw new Exception($gameFromApi['awayTeam']. ' is not the part of our database');
        // }

        if(!$homeTeam || !$awayTeam)
        {
            $valid = false;  
        }

        /** @var Game $game */
        $game = $this->gameRepository->findOneBy(
            [
                'homeTeam' => $homeTeam,
                'awayTeam' => $awayTeam,
                'gameTime' => new DateTimeImmutable($gameFromApi['gameTime'])
            ]
        );

        if ($game) {
            $game->completed($gameFromApi['score']);
            $this->gameRepository->save($game);
        }

        return $valid;
    }

}