<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210320174703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` ADD travaux_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39495C4E2 FOREIGN KEY (travaux_id) REFERENCES travaux (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B39495C4E2 ON `like` (travaux_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3A76ED395 ON `like` (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39495C4E2');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('DROP INDEX IDX_AC6340B39495C4E2 ON `like`');
        $this->addSql('DROP INDEX IDX_AC6340B3A76ED395 ON `like`');
        $this->addSql('ALTER TABLE `like` DROP travaux_id, DROP user_id');
    }
}
