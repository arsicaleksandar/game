<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707121132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, league INT DEFAULT NULL, home_team INT DEFAULT NULL, away_team INT DEFAULT NULL, game_time DATETIME NOT NULL, score VARCHAR(50) DEFAULT NULL, INDEX IDX_232B318C3EB4C318 (league), INDEX IDX_232B318CE5C617D0 (home_team), INDEX IDX_232B318C558F2381 (away_team), UNIQUE INDEX gameIndex (home_team, away_team, game_time), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guess (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, player_id INT DEFAULT NULL, guess VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_32D30F96E48FD905 (game_id), INDEX IDX_32D30F9699E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, league_name_slugged VARCHAR(50) DEFAULT NULL, logo VARCHAR(150) DEFAULT NULL, league_api_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) DEFAULT NULL, password VARCHAR(500) DEFAULT NULL, isActive TINYINT(1) DEFAULT NULL, point INT DEFAULT NULL, email VARCHAR(100) NOT NULL, avatar INT DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX username (username), UNIQUE INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, logo VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3EB4C318 FOREIGN KEY (league) REFERENCES league (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE5C617D0 FOREIGN KEY (home_team) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C558F2381 FOREIGN KEY (away_team) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F96E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guess ADD CONSTRAINT FK_32D30F9699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guess DROP FOREIGN KEY FK_32D30F96E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3EB4C318');
        $this->addSql('ALTER TABLE guess DROP FOREIGN KEY FK_32D30F9699E6F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE5C617D0');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C558F2381');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE guess');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE team');
    }
}
