<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702131654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE procurement_customers (id UUID NOT NULL, business_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN procurement_customers.id IS \'(DC2Type:procurement_customer_id)\'');
        $this->addSql('CREATE TABLE procurement_proposal_scores (id UUID NOT NULL, proposal_id UUID NOT NULL, criteria_id UUID NOT NULL, score INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_633EFC68F4792058 ON procurement_proposal_scores (proposal_id)');
        $this->addSql('CREATE INDEX IDX_633EFC68990BEA15 ON procurement_proposal_scores (criteria_id)');
        $this->addSql('COMMENT ON COLUMN procurement_proposal_scores.proposal_id IS \'(DC2Type:procurement_proposal_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_proposal_scores.score IS \'(DC2Type:procurement_proposal_score)\'');
        $this->addSql('CREATE TABLE procurement_proposals (id UUID NOT NULL, supplier_id UUID NOT NULL, request_id UUID NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C313F6B2ADD6D8C ON procurement_proposals (supplier_id)');
        $this->addSql('CREATE INDEX IDX_5C313F6B427EB8A5 ON procurement_proposals (request_id)');
        $this->addSql('COMMENT ON COLUMN procurement_proposals.id IS \'(DC2Type:procurement_proposal_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_proposals.supplier_id IS \'(DC2Type:procurement_supplier_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_proposals.request_id IS \'(DC2Type:procurement_request_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_proposals.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN procurement_proposals.status IS \'(DC2Type:procurement_proposal_status)\'');
        $this->addSql('CREATE TABLE procurement_request_criterias (id UUID NOT NULL, request_id UUID NOT NULL, name VARCHAR(255) NOT NULL, percent DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AE07408A427EB8A5 ON procurement_request_criterias (request_id)');
        $this->addSql('COMMENT ON COLUMN procurement_request_criterias.request_id IS \'(DC2Type:procurement_request_id)\'');
        $this->addSql('CREATE TABLE procurement_requests (id UUID NOT NULL, customer_id UUID NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_495F5DCD9395C3F3 ON procurement_requests (customer_id)');
        $this->addSql('COMMENT ON COLUMN procurement_requests.id IS \'(DC2Type:procurement_request_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_requests.customer_id IS \'(DC2Type:procurement_customer_id)\'');
        $this->addSql('COMMENT ON COLUMN procurement_requests.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN procurement_requests.status IS \'(DC2Type:procurement_request_status)\'');
        $this->addSql('CREATE TABLE procurement_suppliers (id UUID NOT NULL, business_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN procurement_suppliers.id IS \'(DC2Type:procurement_supplier_id)\'');
        $this->addSql('ALTER TABLE procurement_proposal_scores ADD CONSTRAINT FK_633EFC68F4792058 FOREIGN KEY (proposal_id) REFERENCES procurement_proposals (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE procurement_proposal_scores ADD CONSTRAINT FK_633EFC68990BEA15 FOREIGN KEY (criteria_id) REFERENCES procurement_request_criterias (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE procurement_proposals ADD CONSTRAINT FK_5C313F6B2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES procurement_suppliers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE procurement_proposals ADD CONSTRAINT FK_5C313F6B427EB8A5 FOREIGN KEY (request_id) REFERENCES procurement_requests (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE procurement_request_criterias ADD CONSTRAINT FK_AE07408A427EB8A5 FOREIGN KEY (request_id) REFERENCES procurement_requests (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE procurement_requests ADD CONSTRAINT FK_495F5DCD9395C3F3 FOREIGN KEY (customer_id) REFERENCES procurement_customers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE procurement_requests DROP CONSTRAINT FK_495F5DCD9395C3F3');
        $this->addSql('ALTER TABLE procurement_proposal_scores DROP CONSTRAINT FK_633EFC68F4792058');
        $this->addSql('ALTER TABLE procurement_proposal_scores DROP CONSTRAINT FK_633EFC68990BEA15');
        $this->addSql('ALTER TABLE procurement_proposals DROP CONSTRAINT FK_5C313F6B427EB8A5');
        $this->addSql('ALTER TABLE procurement_request_criterias DROP CONSTRAINT FK_AE07408A427EB8A5');
        $this->addSql('ALTER TABLE procurement_proposals DROP CONSTRAINT FK_5C313F6B2ADD6D8C');
        $this->addSql('DROP TABLE procurement_customers');
        $this->addSql('DROP TABLE procurement_proposal_scores');
        $this->addSql('DROP TABLE procurement_proposals');
        $this->addSql('DROP TABLE procurement_request_criterias');
        $this->addSql('DROP TABLE procurement_requests');
        $this->addSql('DROP TABLE procurement_suppliers');
    }
}
