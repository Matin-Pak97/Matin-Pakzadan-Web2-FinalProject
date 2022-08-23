<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823123013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, booked_by_id INT NOT NULL, INDEX IDX_E00CEDDEF4A5BD90 (booked_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, market_name VARCHAR(255) NOT NULL, max_capacity INT NOT NULL, min_capacity INT NOT NULL, checkin_time TIME DEFAULT NULL, checkout_time TIME DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8BF21CDEC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate_plan (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, price INT NOT NULL, is_default TINYINT(1) NOT NULL, extra_guest_price INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_225EE972549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF4A5BD90 FOREIGN KEY (booked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC54C8C93 FOREIGN KEY (type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE rate_plan ADD CONSTRAINT FK_225EE972549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF4A5BD90');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEC54C8C93');
        $this->addSql('ALTER TABLE rate_plan DROP FOREIGN KEY FK_225EE972549213EC');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE rate_plan');
    }
}
