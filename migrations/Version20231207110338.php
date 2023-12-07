<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207110338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO public.products values ('jfsdjfjksdhfkj23', 'apple', 10, 12)");
        $this->addSql("INSERT INTO public.products values ('A232323SsdfsdfAFFE', 'carrot', 102, 122)");
        $this->addSql("INSERT INTO public.products values ('A2323sdfsdf23SAFFE', 'cucumber', 5, 8)");
        $this->addSql("INSERT INTO public.products values ('dfjshsdfsdffsjh13123', 'pear', 10, 5)");
        $this->addSql("INSERT INTO public.products values ('dfjshfsdfsdfjh13123sd', 'tomato', 102, 12)");
        $this->addSql("INSERT INTO public.warehouses (name, availability) values ('warehouse1', true)");
        $this->addSql("INSERT INTO public.warehouses (name, availability) values ('warehouse2', true)");
        $this->addSql("INSERT INTO public.warehouses (name, availability) values ('warehouse2', false)");

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM public.reservations');
        $this->addSql('DELETE FROM public.products');
        $this->addSql('DELETE FROM public.warehouses');
    }
}
