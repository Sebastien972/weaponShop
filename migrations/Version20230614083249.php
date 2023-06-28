<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614083249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "Cart" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, delivery_adress CLOB NOT NULL, is_paid BOOLEAN NOT NULL, more_information CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , quantity INTEGER NOT NULL, sub_total DOUBLE PRECISION NOT NULL, CONSTRAINT FK_AB912789A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AB912789A76ED395 ON "Cart" (user_id)');
        $this->addSql('CREATE TABLE adress (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, adress CLOB NOT NULL, country VARCHAR(255) NOT NULL, postal_code INTEGER NOT NULL, city VARCHAR(255) NOT NULL, phone INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL, CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5CECC7BEA76ED395 ON adress (user_id)');
        $this->addSql('CREATE TABLE armament (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, categorie_id INTEGER DEFAULT NULL, calibre_id INTEGER NOT NULL, name VARCHAR(25) NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, more_information CLOB DEFAULT NULL, quantity INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , tags CLOB DEFAULT NULL, slug VARCHAR(255) NOT NULL, most_popular BOOLEAN DEFAULT NULL, image2 VARCHAR(255) NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_39EA292EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_39EA292E58FEF8CD FOREIGN KEY (calibre_id) REFERENCES caliber (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_39EA292EBCF5E72D ON armament (categorie_id)');
        $this->addSql('CREATE INDEX IDX_39EA292E58FEF8CD ON armament (calibre_id)');
        $this->addSql('CREATE INDEX armamen ON armament (name, description)');
        $this->addSql('CREATE TABLE caliber (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, calibre DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE cart_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, carts_id INTEGER NOT NULL, weapon_name VARCHAR(255) NOT NULL, weapon_price DOUBLE PRECISION NOT NULL, quantity DOUBLE PRECISION NOT NULL, sub_total DOUBLE PRECISION NOT NULL, CONSTRAINT FK_89FCC38DBCB5C6F5 FOREIGN KEY (carts_id) REFERENCES "Cart" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_89FCC38DBCB5C6F5 ON cart_details (carts_id)');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, delivery_adress CLOB NOT NULL, is_paid BOOLEAN NOT NULL, more_information CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , quantity INTEGER NOT NULL, sub_total DOUBLE PRECISION NOT NULL, stripe_checkout_session_id VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('CREATE TABLE order_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, orders_id INTEGER NOT NULL, weapon_name VARCHAR(255) NOT NULL, weapon_price DOUBLE PRECISION NOT NULL, quantity DOUBLE PRECISION NOT NULL, sub_total DOUBLE PRECISION NOT NULL, CONSTRAINT FK_845CA2C1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_845CA2C1CFFE9AD6 ON order_details (orders_id)');
        $this->addSql('CREATE TABLE related_armament (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, armament_id INTEGER DEFAULT NULL, CONSTRAINT FK_9F696783500B3A6E FOREIGN KEY (armament_id) REFERENCES armament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9F696783500B3A6E ON related_armament (armament_id)');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('CREATE TABLE tags_armament (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE tags_armament_armament (tags_armament_id INTEGER NOT NULL, armament_id INTEGER NOT NULL, PRIMARY KEY(tags_armament_id, armament_id), CONSTRAINT FK_62BED9908764519C FOREIGN KEY (tags_armament_id) REFERENCES tags_armament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_62BED990500B3A6E FOREIGN KEY (armament_id) REFERENCES armament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_62BED9908764519C ON tags_armament_armament (tags_armament_id)');
        $this->addSql('CREATE INDEX IDX_62BED990500B3A6E ON tags_armament_armament (armament_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "Cart"');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE armament');
        $this->addSql('DROP TABLE caliber');
        $this->addSql('DROP TABLE cart_details');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE related_armament');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tags_armament');
        $this->addSql('DROP TABLE tags_armament_armament');
        $this->addSql('DROP TABLE user');
    }
}
