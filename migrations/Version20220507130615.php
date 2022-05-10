<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507130615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD statut_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCCBDFC9D9 FOREIGN KEY (statut_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCCBDFC9D9 ON commentaire (statut_user_id)');
        $this->addSql('ALTER TABLE note ADD statut_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14CBDFC9D9 FOREIGN KEY (statut_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14CBDFC9D9 ON note (statut_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command CHANGE description description VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCCBDFC9D9');
        $this->addSql('DROP INDEX IDX_67F068BCCBDFC9D9 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP statut_user_id, CHANGE contenu contenu VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE menu CHANGE nom nom VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE imgSrc imgSrc VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE saison saison VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14CBDFC9D9');
        $this->addSql('DROP INDEX IDX_CFBDFA14CBDFC9D9 ON note');
        $this->addSql('ALTER TABLE note DROP statut_user_id');
        $this->addSql('ALTER TABLE plat CHANGE nom_plat nom_plat VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservation CHANGE des des VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurant CHANGE nom nom VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE position position VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE image image VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE gerant_restaurant gerant_restaurant VARCHAR(256) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE activation_token activation_token VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE reset_token reset_token VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_tel num_tel VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE genre genre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
