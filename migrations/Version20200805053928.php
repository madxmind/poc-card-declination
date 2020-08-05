<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805053928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_product (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, product_declination_id INT DEFAULT NULL, quantity SMALLINT NOT NULL, INDEX IDX_84508EDBA76ED395 (user_id), INDEX IDX_84508EDB4584665A (product_id), INDEX IDX_84508EDBCA28D71E (product_declination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE declination (id INT AUTO_INCREMENT NOT NULL, declination_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3D58564518D19A2 (declination_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE declination_category (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quantity SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_declination (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, quantity SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_9177C85A4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_declination_declination (product_declination_id INT NOT NULL, declination_id INT NOT NULL, INDEX IDX_67B8537FCA28D71E (product_declination_id), INDEX IDX_67B8537F9941A932 (declination_id), PRIMARY KEY(product_declination_id, declination_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_product ADD CONSTRAINT FK_84508EDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card_product ADD CONSTRAINT FK_84508EDB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE card_product ADD CONSTRAINT FK_84508EDBCA28D71E FOREIGN KEY (product_declination_id) REFERENCES product_declination (id)');
        $this->addSql('ALTER TABLE declination ADD CONSTRAINT FK_3D58564518D19A2 FOREIGN KEY (declination_category_id) REFERENCES declination_category (id)');
        $this->addSql('ALTER TABLE product_declination ADD CONSTRAINT FK_9177C85A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_declination_declination ADD CONSTRAINT FK_67B8537FCA28D71E FOREIGN KEY (product_declination_id) REFERENCES product_declination (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_declination_declination ADD CONSTRAINT FK_67B8537F9941A932 FOREIGN KEY (declination_id) REFERENCES declination (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_declination_declination DROP FOREIGN KEY FK_67B8537F9941A932');
        $this->addSql('ALTER TABLE declination DROP FOREIGN KEY FK_3D58564518D19A2');
        $this->addSql('ALTER TABLE card_product DROP FOREIGN KEY FK_84508EDB4584665A');
        $this->addSql('ALTER TABLE product_declination DROP FOREIGN KEY FK_9177C85A4584665A');
        $this->addSql('ALTER TABLE card_product DROP FOREIGN KEY FK_84508EDBCA28D71E');
        $this->addSql('ALTER TABLE product_declination_declination DROP FOREIGN KEY FK_67B8537FCA28D71E');
        $this->addSql('ALTER TABLE card_product DROP FOREIGN KEY FK_84508EDBA76ED395');
        $this->addSql('DROP TABLE card_product');
        $this->addSql('DROP TABLE declination');
        $this->addSql('DROP TABLE declination_category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_declination');
        $this->addSql('DROP TABLE product_declination_declination');
        $this->addSql('DROP TABLE user');
    }
}
