<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220729212903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE colectivo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genero_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persona_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE relacioncolectivo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE relacionpersona_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiporelacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE colectivo (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genero (id INT NOT NULL, genero VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE persona (id INT NOT NULL, genero_id INT DEFAULT NULL, nombre VARCHAR(50) DEFAULT NULL, apellidos VARCHAR(80) DEFAULT NULL, apodo VARCHAR(50) DEFAULT NULL, nacimiento DATE DEFAULT NULL, comentarios TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51E5B69BBCE7B795 ON persona (genero_id)');
        $this->addSql('CREATE TABLE relacioncolectivo (id INT NOT NULL, persona_id INT DEFAULT NULL, colectivo_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_870D14BAF5F88DB9 ON relacioncolectivo (persona_id)');
        $this->addSql('CREATE INDEX IDX_870D14BADF75D996 ON relacioncolectivo (colectivo_id)');
        $this->addSql('CREATE TABLE relacionpersona (id INT NOT NULL, persona1_id INT DEFAULT NULL, persona2_id INT DEFAULT NULL, tiporelacion_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_383F80C66424DE36 ON relacionpersona (persona1_id)');
        $this->addSql('CREATE INDEX IDX_383F80C6769171D8 ON relacionpersona (persona2_id)');
        $this->addSql('CREATE INDEX IDX_383F80C662E2C14B ON relacionpersona (tiporelacion_id)');
        $this->addSql('CREATE TABLE tiporelacion (id INT NOT NULL, tipo VARCHAR(255) NOT NULL, tipocontrario VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69BBCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE relacioncolectivo ADD CONSTRAINT FK_870D14BAF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE relacioncolectivo ADD CONSTRAINT FK_870D14BADF75D996 FOREIGN KEY (colectivo_id) REFERENCES colectivo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE relacionpersona ADD CONSTRAINT FK_383F80C66424DE36 FOREIGN KEY (persona1_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE relacionpersona ADD CONSTRAINT FK_383F80C6769171D8 FOREIGN KEY (persona2_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE relacionpersona ADD CONSTRAINT FK_383F80C662E2C14B FOREIGN KEY (tiporelacion_id) REFERENCES tiporelacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE relacioncolectivo DROP CONSTRAINT FK_870D14BADF75D996');
        $this->addSql('ALTER TABLE persona DROP CONSTRAINT FK_51E5B69BBCE7B795');
        $this->addSql('ALTER TABLE relacioncolectivo DROP CONSTRAINT FK_870D14BAF5F88DB9');
        $this->addSql('ALTER TABLE relacionpersona DROP CONSTRAINT FK_383F80C66424DE36');
        $this->addSql('ALTER TABLE relacionpersona DROP CONSTRAINT FK_383F80C6769171D8');
        $this->addSql('ALTER TABLE relacionpersona DROP CONSTRAINT FK_383F80C662E2C14B');
        $this->addSql('DROP SEQUENCE colectivo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genero_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persona_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE relacioncolectivo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE relacionpersona_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiporelacion_id_seq CASCADE');
        $this->addSql('DROP TABLE colectivo');
        $this->addSql('DROP TABLE genero');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE relacioncolectivo');
        $this->addSql('DROP TABLE relacionpersona');
        $this->addSql('DROP TABLE tiporelacion');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
