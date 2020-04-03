<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330081534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB7F2DEE08 ON location (facture_id)');
        $this->addSql('ALTER TABLE sell ADD facture_id INT NOT NULL, ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE sell ADD CONSTRAINT FK_9B9ED07D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_9B9ED07D7F2DEE08 ON sell (facture_id)');
        $this->addSql('CREATE INDEX IDX_9B9ED07D19EB6921 ON sell (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB7F2DEE08');
        $this->addSql('DROP INDEX IDX_5E9E89CB7F2DEE08 ON location');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D7F2DEE08');
        $this->addSql('ALTER TABLE sell DROP FOREIGN KEY FK_9B9ED07D19EB6921');
        $this->addSql('DROP INDEX IDX_9B9ED07D7F2DEE08 ON sell');
        $this->addSql('DROP INDEX IDX_9B9ED07D19EB6921 ON sell');
        $this->addSql('ALTER TABLE sell DROP facture_id, DROP client_id');
    }
}
