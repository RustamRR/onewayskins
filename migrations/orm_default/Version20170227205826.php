<?php

namespace OrmDefaultMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170227205826 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (steam_id INT AUTO_INCREMENT NOT NULL, id INT NOT NULL, password VARCHAR(255) NOT NULL, personaname VARCHAR(255) NOT NULL, profileurl VARCHAR(255) NOT NULL, realname VARCHAR(255) NOT NULL, primaryclanid VARCHAR(255) NOT NULL, loccountrycode VARCHAR(255) NOT NULL, locstatecode VARCHAR(255) NOT NULL, loccityid VARCHAR(255) NOT NULL, registration_date DATETIME NOT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9BF396750 (id), UNIQUE INDEX UNIQ_1483A5E9F3FD4ECA (steam_id), PRIMARY KEY(steam_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
    }
}
