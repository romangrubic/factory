<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613142235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255), slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_translations (id INT AUTO_INCREMENT NOT NULL, categories_id_id INT NOT NULL, locale VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_95D326DC1420680F (categories_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_translations ADD CONSTRAINT FK_95D326DC1420680F FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_translations DROP FOREIGN KEY FK_95D326DC1420680F');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_translations');
    }
}
