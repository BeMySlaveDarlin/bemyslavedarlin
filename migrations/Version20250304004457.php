<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250304004457 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE about (
                id SERIAL PRIMARY KEY,
                title TEXT NOT NULL,
                description TEXT,
                type VARCHAR(64) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS public.about');
    }
}
