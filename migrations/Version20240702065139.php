<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702065139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candy_color (candy_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_78C84AC2C7FC73F3 (candy_id), INDEX IDX_78C84AC27ADA1FB5 (color_id), PRIMARY KEY(candy_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candy_taste (candy_id INT NOT NULL, taste_id INT NOT NULL, INDEX IDX_7748DC73C7FC73F3 (candy_id), INDEX IDX_7748DC7374E52521 (taste_id), PRIMARY KEY(candy_id, taste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candy_color ADD CONSTRAINT FK_78C84AC2C7FC73F3 FOREIGN KEY (candy_id) REFERENCES candy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candy_color ADD CONSTRAINT FK_78C84AC27ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candy_taste ADD CONSTRAINT FK_7748DC73C7FC73F3 FOREIGN KEY (candy_id) REFERENCES candy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candy_taste ADD CONSTRAINT FK_7748DC7374E52521 FOREIGN KEY (taste_id) REFERENCES taste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candy ADD brand_id INT NOT NULL, CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE candy ADD CONSTRAINT FK_F12BEBF744F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_F12BEBF744F5D008 ON candy (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candy DROP FOREIGN KEY FK_F12BEBF744F5D008');
        $this->addSql('ALTER TABLE candy_color DROP FOREIGN KEY FK_78C84AC2C7FC73F3');
        $this->addSql('ALTER TABLE candy_color DROP FOREIGN KEY FK_78C84AC27ADA1FB5');
        $this->addSql('ALTER TABLE candy_taste DROP FOREIGN KEY FK_7748DC73C7FC73F3');
        $this->addSql('ALTER TABLE candy_taste DROP FOREIGN KEY FK_7748DC7374E52521');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE candy_color');
        $this->addSql('DROP TABLE candy_taste');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE taste');
        $this->addSql('DROP INDEX IDX_F12BEBF744F5D008 ON candy');
        $this->addSql('ALTER TABLE candy DROP brand_id, CHANGE name name VARCHAR(255) NOT NULL');
    }
}
