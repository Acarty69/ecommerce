<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103130207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE oder_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE oder_item (id INT NOT NULL, product_id INT DEFAULT NULL, oforder_id INT DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2A0A990A4584665A ON oder_item (product_id)');
        $this->addSql('CREATE INDEX IDX_2A0A990A4A27DF4 ON oder_item (oforder_id)');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, shipping_adresse_id INT DEFAULT NULL, billing_adresse_id INT DEFAULT NULL, total INT NOT NULL, createdat TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5299398F51C8C02 ON "order" (shipping_adresse_id)');
        $this->addSql('CREATE INDEX IDX_F5299398C180B3CD ON "order" (billing_adresse_id)');
        $this->addSql('ALTER TABLE oder_item ADD CONSTRAINT FK_2A0A990A4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oder_item ADD CONSTRAINT FK_2A0A990A4A27DF4 FOREIGN KEY (oforder_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398F51C8C02 FOREIGN KEY (shipping_adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398C180B3CD FOREIGN KEY (billing_adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "user"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE oder_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON "user" (username)');
        $this->addSql('ALTER TABLE oder_item DROP CONSTRAINT FK_2A0A990A4584665A');
        $this->addSql('ALTER TABLE oder_item DROP CONSTRAINT FK_2A0A990A4A27DF4');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398F51C8C02');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398C180B3CD');
        $this->addSql('DROP TABLE oder_item');
        $this->addSql('DROP TABLE "order"');
    }
}
