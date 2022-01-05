<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104221807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D232AD8AB');
        $this->addSql('DROP INDEX IDX_6EEAA67D232AD8AB ON commande');
        $this->addSql('ALTER TABLE commande_details DROP FOREIGN KEY commande_details_ibfk_1');
        $this->addSql('DROP INDEX user_id ON commande_details');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY panier_ibfk_1');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY panier_ibfk_2');
        $this->addSql('DROP INDEX article_id ON panier');
        $this->addSql('DROP INDEX user_id ON panier');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D232AD8AB FOREIGN KEY (client_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EEAA67D232AD8AB ON commande (client_id)');
        $this->addSql('ALTER TABLE commande_details ADD CONSTRAINT commande_details_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX user_id ON commande_details (user_id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT panier_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT panier_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX article_id ON panier (article_id)');
        $this->addSql('CREATE INDEX user_id ON panier (user_id)');
    }
}
