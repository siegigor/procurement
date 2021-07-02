<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal;

interface ProposalRepository
{
    public function get(Id $id): Proposal;

    public function add(Proposal $proposal): void;

    public function remove(Proposal $proposal): void;
}
