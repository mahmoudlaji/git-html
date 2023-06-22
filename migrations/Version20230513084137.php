<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513084137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_tags (annonce_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_557AEAEF8805AB2F (annonce_id), INDEX IDX_557AEAEFBAD26311 (tag_id), PRIMARY KEY(annonce_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEF8805AB2F');
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEFBAD26311');
        $this->addSql('DROP TABLE annonces_tags');
        $this->addSql('DROP TABLE tag');
    }
}
