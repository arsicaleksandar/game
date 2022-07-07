<?php

namespace Guess\Infrastructure\Command;

use Exception;
use Guess\Application\Handler\Game\GameOverHandler;
use Guess\Domain\Game\Game;
use Guess\Infrastructure\Services\FetchGamesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchScoresCommand extends Command
{
    protected static $defaultName = 'app:fetch-scores';
    private FetchGamesInterface $fetchGames;
    private GameOverHandler $gameOverHandler;

    public function __construct(
        FetchGamesInterface $fetchGames,
        GameOverHandler $gameOverHandler
    )
    {
        $this->fetchGames = $fetchGames;
        $this->gameOverHandler = $gameOverHandler;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->fetchGames->fetch(
            ['days' => $input->getArgument('days')]
        );

        $count  = 0;
        /** @var Game $game */
        foreach ($games as $game) {
            try {
                $checkInDatabase = $this->gameOverHandler->handle($game);
                if($checkInDatabase)
                {
                    $output->writeln(
                        "Score is saved: " .
                        $game['score'] .
                        " for " .
                        $game['homeTeam'].
                        " - " .
                        $game['awayTeam']
                    );

                    $count++;
                }
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        if($count > 0){
            $output->writeln('Scores are saved.');
        }
        else
        {
            $output->writeln('No scores has been saved.');
        }

        return Command::SUCCESS;
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('days', InputArgument::REQUIRED);
    }
}