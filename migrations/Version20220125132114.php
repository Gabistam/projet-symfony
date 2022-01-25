<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125132114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD26EF07C9');
        $this->addSql('DROP INDEX IDX_D34A04AD3DA5256D ON product');
        $this->addSql('ALTER TABLE product DROP image_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD26EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD adress VARCHAR(255) NOT NULL, ADD zipcode VARCHAR(255) NOT NULL, ADD date DATE NOT NULL, ADD card_number VARCHAR(255) NOT NULL, ADD card_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD26EF07C9');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD26EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD3DA5256D ON product (image_id)');
        $this->addSql('ALTER TABLE user DROP name, DROP firstname, DROP city, DROP adress, DROP zipcode, DROP date, DROP card_number, DROP card_name');
    }
}
