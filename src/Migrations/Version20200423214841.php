<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423214841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, list_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E7927C74C35F0816 (adresse), INDEX IDX_E7927C743DAE168B (list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_mail (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, contact INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_14E873A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C743DAE168B FOREIGN KEY (list_id) REFERENCES list_mail (id)');
        $this->addSql('ALTER TABLE list_mail ADD CONSTRAINT FK_14E873A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C743DAE168B');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE list_mail');
    }
}
