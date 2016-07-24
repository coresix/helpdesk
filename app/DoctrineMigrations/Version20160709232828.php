<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160709232828 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, ticketstatus_id INT DEFAULT NULL, assignee_userid INT DEFAULT NULL, created_userid INT DEFAULT NULL, created_time DATETIME NOT NULL, subject VARCHAR(255) NOT NULL, priority INT NOT NULL, message VARCHAR(255) NOT NULL, INDEX createduser_idx (created_userid), INDEX assignee_idx (assignee_userid), INDEX department_idx (department_id), INDEX status_idx (ticketstatus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4AE80F5DF FOREIGN KEY (department_id) REFERENCES departments (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4C05EB95C FOREIGN KEY (ticketstatus_id) REFERENCES tickets_status (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4A58EC17E FOREIGN KEY (assignee_userid) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4F29E56C1 FOREIGN KEY (created_userid) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4C05EB95C');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE tickets_status');
    }
}
