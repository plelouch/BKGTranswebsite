<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330083652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sell ADD property_id INT DEFAULT NULL, ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07DC3C6F69F FOREIGN KEY (car_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_9B9ED07D549213EC ON sell (property_id)');
        $this->addSql('CREATE INDEX IDX_9B9ED07DC3C6F69F ON sell (car_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D549213EC');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07DC3C6F69F');
        $this->addSql('DROP INDEX IDX_9B9ED07D549213EC ON sell');
        $this->addSql('DROP INDEX IDX_9B9ED07DC3C6F69F ON sell');
        $this->addSql('ALTER TABLE sell DROP property_id, DROP car_id');
    }
}
