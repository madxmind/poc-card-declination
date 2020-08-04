<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804182601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_declination_product (product_declination_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_6657E8EBCA28D71E (product_declination_id), INDEX IDX_6657E8EB4584665A (product_id), PRIMARY KEY(product_declination_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_declination_product ADD CONSTRAINT FK_6657E8EBCA28D71E FOREIGN KEY (product_declination_id) REFERENCES product_declination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_declination_product ADD CONSTRAINT FK_6657E8EB4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_declination DROP FOREIGN KEY FK_9177C85A4584665A');
        $this->addSql('DROP INDEX IDX_9177C85A4584665A ON product_declination');
        $this->addSql('ALTER TABLE product_declination DROP product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_declination_product');
        $this->addSql('ALTER TABLE product_declination ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_declination ADD CONSTRAINT FK_9177C85A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_9177C85A4584665A ON product_declination (product_id)');
    }
}
