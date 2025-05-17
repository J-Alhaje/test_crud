<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516145703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE smartphone ADD vendor_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE smartphone ADD CONSTRAINT FK_26B07E2EF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_26B07E2EF603EE73 ON smartphone (vendor_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE smartphone DROP FOREIGN KEY FK_26B07E2EF603EE73
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_26B07E2EF603EE73 ON smartphone
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE smartphone DROP vendor_id
        SQL);
    }
}
