<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804183920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_declination_declination (product_declination_id INT NOT NULL, declination_id INT NOT NULL, INDEX IDX_67B8537FCA28D71E (product_declination_id), INDEX IDX_67B8537F9941A932 (declination_id), PRIMARY KEY(product_declination_id, declination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_declination_declination ADD CONSTRAINT FK_67B8537FCA28D71E FOREIGN KEY (product_declination_id) REFERENCES product_declination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_declination_declination ADD CONSTRAINT FK_67B8537F9941A932 FOREIGN KEY (declination_id) REFERENCES declination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_declination DROP FOREIGN KEY FK_9177C85A9941A932');
        $this->addSql('DROP INDEX IDX_9177C85A9941A932 ON product_declination');
        $this->addSql('ALTER TABLE product_declination DROP declination_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_declination_declination');
        $this->addSql('ALTER TABLE product_declination ADD declination_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_declination ADD CONSTRAINT FK_9177C85A9941A932 FOREIGN KEY (declination_id) REFERENCES declination (id)');
        $this->addSql('CREATE INDEX IDX_9177C85A9941A932 ON product_declination (declination_id)');
    }
}
