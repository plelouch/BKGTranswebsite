<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330083327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEACE745F4');
        $this->addSql('DROP INDEX IDX_8BF21CDEACE745F4 ON property');
        $this->addSql('ALTER TABLE property DROP sell_id');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FACE745F4');
        $this->addSql('DROP INDEX IDX_E9E2810FACE745F4 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP sell_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property ADD sell_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEACE745F4 FOREIGN KEY (sell_id) REFERENCES sell (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEACE745F4 ON property (sell_id)');
        $this->addSql('ALTER TABLE voiture ADD sell_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FACE745F4 FOREIGN KEY (sell_id) REFERENCES sell (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FACE745F4 ON voiture (sell_id)');
    }
}
