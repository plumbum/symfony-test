<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180707101001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE author (id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX fullname_unique ON author (first_name, middle_name, last_name)');
        $this->addSql('CREATE TABLE author_book (author_id INTEGER NOT NULL, book_id INTEGER NOT NULL, PRIMARY KEY(author_id, book_id))');
        $this->addSql('CREATE INDEX IDX_2F0A2BEEF675F31B ON author_book (author_id)');
        $this->addSql('CREATE INDEX IDX_2F0A2BEE16A2B381 ON author_book (book_id)');
        $this->addSql('CREATE TABLE book (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, year INTEGER NOT NULL, isbn NUMERIC(13, 0) NOT NULL, pages INTEGER NOT NULL, cover VARCHAR(255) DEFAULT NULL, author_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX titleyear_unique ON book (title, year)');
        $this->addSql('CREATE UNIQUE INDEX isbn_unique ON book (ISBN)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE book');
    }
}
