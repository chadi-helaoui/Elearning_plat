<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220827113636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67C7ECF78B0');
        $this->addSql('DROP TABLE owner');
        $this->addSql('ALTER TABLE cours ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C7E3C61F9 ON cours (owner_id)');
        $this->addSql('ALTER TABLE enseignant DROP email, DROP roles, DROP password');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, INDEX IDX_CF60E67C7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67C7ECF78B0 FOREIGN KEY (cours_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C7E3C61F9');
        $this->addSql('DROP INDEX IDX_FDCA8C9C7E3C61F9 ON cours');
        $this->addSql('ALTER TABLE cours DROP owner_id');
        $this->addSql('ALTER TABLE enseignant ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL');
    }
}
