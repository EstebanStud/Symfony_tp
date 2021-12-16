<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214145036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_user (mission_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4D17A46BE6CAE90 (mission_id), INDEX IDX_A4D17A46A76ED395 (user_id), PRIMARY KEY(mission_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission ADD description LONGTEXT NOT NULL, ADD priority VARCHAR(255) NOT NULL, ADD date DATETIME DEFAULT NULL, ADD statut VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mission_user');
        $this->addSql('ALTER TABLE mission DROP description, DROP priority, DROP date, DROP statut');
    }
}
