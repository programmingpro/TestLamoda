<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206205215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (code VARCHAR(25) NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(code))');
        $this->addSql('CREATE TABLE reservations (product_code VARCHAR(25) NOT NULL, warehouse_id INT NOT NULL, PRIMARY KEY(product_code, warehouse_id))');
        $this->addSql('CREATE INDEX IDX_42C84955FAFD1239 ON reservations (product_code)');
        $this->addSql('CREATE INDEX IDX_42C849555080ECDE ON reservations (warehouse_id)');
        $this->addSql('CREATE TABLE warehouses (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, availability BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_42C84955FAFD1239 FOREIGN KEY (product_code) REFERENCES products (code) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_42C849555080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_42C84955FAFD1239');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_42C849555080ECDE');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE warehouses');
    }
}
