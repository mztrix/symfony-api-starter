<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony Api Starter project.
 * (c) Firstname Lastname <email@domain.tld>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250520225320 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
                CREATE TABLE refresh_token (id UUID NOT NULL, refresh_token VARCHAR(255) NOT NULL, identifier VARCHAR(128) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
            SQL);
        $this->addSql(<<<'SQL'
                COMMENT ON COLUMN refresh_token.id IS '(DC2Type:ulid)'
            SQL);
        $this->addSql(<<<'SQL'
                CREATE TABLE "user" (id UUID NOT NULL, identifier VARCHAR(128) NOT NULL, password VARCHAR(128) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))
            SQL);
        $this->addSql(<<<'SQL'
                CREATE UNIQUE INDEX UNIQ_8D93D649772E836A ON "user" (identifier)
            SQL);
        $this->addSql(<<<'SQL'
                COMMENT ON COLUMN "user".id IS '(DC2Type:ulid)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
                CREATE SCHEMA public
            SQL);
        $this->addSql(<<<'SQL'
                DROP TABLE refresh_token
            SQL);
        $this->addSql(<<<'SQL'
                DROP TABLE "user"
            SQL);
    }
}
