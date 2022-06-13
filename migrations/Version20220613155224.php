<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613155224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meals_translations (id INT AUTO_INCREMENT NOT NULL, meals_id INT NOT NULL, locale VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_6144EB5788A25CA2 (meals_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meals_translations ADD CONSTRAINT FK_6144EB5788A25CA2 FOREIGN KEY (meals_id) REFERENCES meals (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE meals_translations');
    }
}
