<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507094805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_annonces ADD image_name VARCHAR(50) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD image_mime_type VARCHAR(200) DEFAULT NULL, ADD image_original_name VARCHAR(1000) DEFAULT NULL, ADD image_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_annonces DROP image_name, DROP image_size, DROP image_mime_type, DROP image_original_name, DROP image_dimensions, DROP updated_at');
    }
}
