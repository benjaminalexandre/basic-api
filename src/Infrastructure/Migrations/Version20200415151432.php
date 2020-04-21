<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415151432 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE foundation.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE foundation."user" (
          id INT NOT NULL, 
          name VARCHAR(255) NOT NULL, 
          first_name VARCHAR(255) NOT NULL, 
          country_code VARCHAR(3) NOT NULL, 
          created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE ext_log_entries (
          id INT NOT NULL, 
          action VARCHAR(8) NOT NULL, 
          logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
          object_id VARCHAR(64) DEFAULT NULL, 
          object_class VARCHAR(255) NOT NULL, 
          version INT NOT NULL, 
          data TEXT DEFAULT NULL, 
          username VARCHAR(255) DEFAULT NULL, 
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE foundation.user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE foundation."user"');
        $this->addSql('DROP TABLE ext_log_entries');
    }
}
