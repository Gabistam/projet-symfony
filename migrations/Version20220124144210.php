<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124144210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD image_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD licence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD26EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD3DA5256D ON product (image_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD26EF07C9 ON product (licence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD26EF07C9');
        $this->addSql('DROP INDEX IDX_D34A04AD3DA5256D ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD26EF07C9 ON product');
        $this->addSql('ALTER TABLE product DROP image_id, DROP category_id, DROP licence_id');
    }
}
