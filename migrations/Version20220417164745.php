<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417164745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu CHANGE imgSrc imgSrc LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD commenter LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE image image LONGBLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu CHANGE imgSrc imgSrc LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant DROP commenter, CHANGE image image LONGBLOB DEFAULT NULL');
    }
}
