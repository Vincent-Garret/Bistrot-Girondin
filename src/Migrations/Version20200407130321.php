<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407130321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appellation ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE appellation ADD CONSTRAINT FK_187A5B9898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_187A5B9898260155 ON appellation (region_id)');
        $this->addSql('ALTER TABLE wine ADD color_id INT NOT NULL, ADD appellation_id INT NOT NULL');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C64687ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C64687CDE30DD FOREIGN KEY (appellation_id) REFERENCES appellation (id)');
        $this->addSql('CREATE INDEX IDX_560C64687ADA1FB5 ON wine (color_id)');
        $this->addSql('CREATE INDEX IDX_560C64687CDE30DD ON wine (appellation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appellation DROP FOREIGN KEY FK_187A5B9898260155');
        $this->addSql('DROP INDEX IDX_187A5B9898260155 ON appellation');
        $this->addSql('ALTER TABLE appellation DROP region_id');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C64687ADA1FB5');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C64687CDE30DD');
        $this->addSql('DROP INDEX IDX_560C64687ADA1FB5 ON wine');
        $this->addSql('DROP INDEX IDX_560C64687CDE30DD ON wine');
        $this->addSql('ALTER TABLE wine DROP color_id, DROP appellation_id');
    }
}
