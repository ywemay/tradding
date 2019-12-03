<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190909093734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD3DA5256D (image_id), UNIQUE INDEX UNIQ_D34A04AD7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, affiliated_products_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1B920606 (affiliated_products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price_offer (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, offer_date DATETIME NOT NULL, valid_until VARCHAR(255) NOT NULL, INDEX IDX_AE3011414584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B920606 FOREIGN KEY (affiliated_products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_price_offer ADD CONSTRAINT FK_AE3011414584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B920606');
        $this->addSql('ALTER TABLE product_price_offer DROP FOREIGN KEY FK_AE3011414584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7E3C61F9');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product_price_offer');
    }
}
