<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180410191137 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Comment (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, comment_text LONGTEXT NOT NULL, comment_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, password_key VARCHAR(255) NOT NULL, terms INT NOT NULL, last_login_time DATETIME DEFAULT NULL, facebook_id VARCHAR(50) DEFAULT NULL, api_token VARCHAR(255) DEFAULT NULL, twitter_id VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application (app_id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, school_name VARCHAR(255) NOT NULL, contact_person VARCHAR(255) NOT NULL, telfone_number VARCHAR(255) NOT NULL, students_number INT NOT NULL, location VARCHAR(255) DEFAULT NULL, suggestion LONGTEXT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, uploaded_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A45BDDC1A76ED395 (user_id), PRIMARY KEY(app_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('DROP TABLE Comment');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE application');
    }
}
