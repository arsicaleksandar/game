<?php

namespace Guess\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Guess\Domain\Game\Game;
use Guess\Domain\Game\GameRepositoryInterface;
use Guess\Domain\Team\TeamRepositoryInterface;
use Guess\Domain\League\LeagueRepositoryInterface;

class GameOverHandler
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private TeamRepositoryInterface $teamRepository,
        private LeagueRepositoryInterface $leagueRepository
    )
    {
    }

    /**
     * @param array $gameFromApi
     * @throws Exception
     */
    public function handle(array $gameFromApi) : bool
    {
        
        $homeTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['awayTeam']]);
        $league = $this->leagueRepository->findOneBy(['leagueApiId' => $gameFromApi['leagueApiId']]);

        $valid = true;

        if(!$homeTeam || !$awayTeam || !$league || !$gameFromApi['score'])
        {
            $valid = false;  
        }
        
        if ($valid) {
            
            $gameTime = new DateTimeImmutable($gameFromApi['gameTime']);
            $this->gameRepository->save(
                (new Game())
                    ->setHomeTeam($homeTeam)
                    ->setLeague($league)
                    ->setAwayTeam($awayTeam)
                    ->setGameTime($gameTime)
                    ->setScore($gameFromApi['score'] ? $gameFromApi['score'] : null)
            );
        }

        return $valid;
    }

}