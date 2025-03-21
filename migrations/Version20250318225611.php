<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250318225611 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql("CREATE UNIQUE INDEX idx_players_nickname ON public.players (nickname);");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IF EXISTS idx_players_nickname');
    }
}
