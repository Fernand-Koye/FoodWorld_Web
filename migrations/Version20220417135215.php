<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417135215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD like_menu INT DEFAULT NULL, ADD dislike_menu INT DEFAULT NULL, CHANGE imgSrc imgSrc LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD like_restaurant INT DEFAULT NULL, ADD dislike_restaurant INT DEFAULT NULL, CHANGE image image LONGBLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP like_menu, DROP dislike_menu, CHANGE imgSrc imgSrc LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant DROP like_restaurant, DROP dislike_restaurant, CHANGE image image LONGBLOB DEFAULT NULL');
    }
}
