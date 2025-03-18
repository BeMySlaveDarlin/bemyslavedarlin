<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250318120032 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE players (
                id SERIAL PRIMARY KEY,
                nickname VARCHAR(255),
                grade VARCHAR(128) NOT NULL DEFAULT 'Junior',
                money BIGINT NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS public.players');
    }
}
