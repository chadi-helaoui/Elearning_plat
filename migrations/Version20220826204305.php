<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826204305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDCA8C9CE7927C74 ON cours (email)');
        $this->addSql('ALTER TABLE enseignant ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA1E7927C74 ON enseignant (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_FDCA8C9CE7927C74 ON cours');
        $this->addSql('ALTER TABLE cours DROP email, DROP roles, DROP password');
        $this->addSql('DROP INDEX UNIQ_81A72FA1E7927C74 ON enseignant');
        $this->addSql('ALTER TABLE enseignant DROP email, DROP roles, DROP password');
    }
}
