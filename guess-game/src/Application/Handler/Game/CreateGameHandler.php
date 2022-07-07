<?php

namespace Guess\Application\Handler\Game;

use DateTimeImmutable;
use Exception;
use Guess\Domain\Game\Game;
use Guess\Domain\Game\GameRepositoryInterface;
use Guess\Domain\League\LeagueRepositoryInterface;
use Guess\Domain\Team\TeamRepositoryInterface;

class CreateGameHandler
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private TeamRepositoryInterface $teamRepository,
        private LeagueRepositoryInterface $leagueRepository
    )
    {
    }

    /**
     * @param array $game
     * @throws Exception
     */
    public function handle(array $game): bool
    {
        $homeTeam = $this->teamRepository->findOneBy(['name' => $game['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $game['awayTeam']]);
        $league = $this->leagueRepository->findOneBy(['leagueApiId' => $game['leagueApiId']]);
        $valid = true;

        // if (!$homeTeam) {
        //     throw new Exception($game['homeTeam']." is not the part of our database");
        //     //throw new Exception("");
      
        // }

        // if (!$awayTeam) {
        //     throw new Exception($game['awayTeam']." is not the part of our database");
        //     // throw new Exception("");
        // }

        // if (!$league) {
        //     throw new Exception($game['leagueApiId']." League is not the part of our database");
        // }

        // $gameTime = new DateTimeImmutable($game['gameTime']);

        //     $this->gameRepository->save(
        //         (new Game())
        //             ->setHomeTeam($homeTeam)
        //             ->setLeague($league)
        //             ->setAwayTeam($awayTeam)
        //             ->setGameTime($gameTime)
        //     );

        
        if (!$homeTeam || !$awayTeam || !$league) {
            $valid = false;   
        }
        else {
            $gameTime = new DateTimeImmutable($game['gameTime']);
            $this->gameRepository->save(
                (new Game())
                    ->setHomeTeam($homeTeam)
                    ->setLeague($league)
                    ->setAwayTeam($awayTeam)
                    ->setGameTime($gameTime)
            );
        }

        return $valid;
    }
}