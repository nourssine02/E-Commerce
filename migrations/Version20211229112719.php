<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229112719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY panier_ibfk_2');
        $this->addSql('DROP INDEX user_id ON panier');
        $this->addSql('ALTER TABLE panier_article DROP FOREIGN KEY panier_article_ibfk_1');
        $this->addSql('ALTER TABLE panier_article DROP FOREIGN KEY panier_article_ibfk_2');
        $this->addSql('ALTER TABLE panier_article ADD PRIMARY KEY (panier_id, article_id)');
        $this->addSql('ALTER TABLE panier_article ADD CONSTRAINT FK_F880CAE7F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_article ADD CONSTRAINT FK_F880CAE77294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_article RENAME INDEX panier_id TO IDX_F880CAE7F77D927C');
        $this->addSql('ALTER TABLE panier_article RENAME INDEX article_id TO IDX_F880CAE77294869C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT panier_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX user_id ON panier (user_id)');
        $this->addSql('ALTER TABLE panier_article DROP FOREIGN KEY FK_F880CAE7F77D927C');
        $this->addSql('ALTER TABLE panier_article DROP FOREIGN KEY FK_F880CAE77294869C');
        $this->addSql('ALTER TABLE panier_article DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier_article ADD CONSTRAINT panier_article_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE panier_article ADD CONSTRAINT panier_article_ibfk_2 FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier_article RENAME INDEX idx_f880cae77294869c TO article_id');
        $this->addSql('ALTER TABLE panier_article RENAME INDEX idx_f880cae7f77d927c TO panier_id');
    }
}
