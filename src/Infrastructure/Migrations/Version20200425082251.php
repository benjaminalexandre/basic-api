<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425082251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA foundation');
        $this->addSql('CREATE SCHEMA authentication');
        $this->addSql('CREATE SEQUENCE foundation._user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE authentication.account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE foundation._user (
          id INT NOT NULL, 
          account_id INT NOT NULL, 
          name VARCHAR(255) NOT NULL, 
          first_name VARCHAR(255) NOT NULL, 
          email VARCHAR(100) NOT NULL, 
          cellphone VARCHAR(20) DEFAULT NULL, 
          country_code VARCHAR(3) NOT NULL, 
          created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46189EBA9B6B5FBA ON foundation._user (account_id)');
        $this->addSql('CREATE TABLE authentication.account (
          id INT NOT NULL, 
          login VARCHAR(100) NOT NULL, 
          password VARCHAR(200) NOT NULL, 
          is_deleted BOOLEAN DEFAULT \'false\' NOT NULL, 
          created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2230424BAA08CB10 ON authentication.account (login)');
        $this->addSql('ALTER TABLE 
          foundation._user 
        ADD 
          CONSTRAINT FK_46189EBA9B6B5FBA FOREIGN KEY (account_id) REFERENCES authentication.account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE foundation._user DROP CONSTRAINT FK_46189EBA9B6B5FBA');
        $this->addSql('DROP SEQUENCE foundation._user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE authentication.account_id_seq CASCADE');
        $this->addSql('DROP TABLE foundation._user');
        $this->addSql('DROP TABLE authentication.account');
    }
}
