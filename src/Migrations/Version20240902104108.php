<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902104108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F7B092A811');
        $this->addSql('ALTER TABLE order_food_food DROP FOREIGN KEY FK_DD98FADE4CF42E8F');
        $this->addSql('ALTER TABLE order_food_food DROP FOREIGN KEY FK_DD98FADEBA8E87C4');
        $this->addSql('DROP TABLE food');
        $this->addSql('DROP TABLE order_food_food');
        $this->addSql('DROP TABLE order_food');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, flavors VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D43829F7B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_food_food (order_food_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_DD98FADE4CF42E8F (order_food_id), INDEX IDX_DD98FADEBA8E87C4 (food_id), PRIMARY KEY(order_food_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_food (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F7B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_food_food ADD CONSTRAINT FK_DD98FADE4CF42E8F FOREIGN KEY (order_food_id) REFERENCES order_food (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_food_food ADD CONSTRAINT FK_DD98FADEBA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
