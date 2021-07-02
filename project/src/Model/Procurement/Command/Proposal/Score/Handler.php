<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Score;

use App\Model\Flusher;
use App\Model\Procurement\Entity\Supplier\Proposal\Id;
use App\Model\Procurement\Entity\Supplier\Proposal\ProposalRepository;

class Handler
{
    public function __construct(private ProposalRepository $proposals, private Flusher $flusher)
    {
    }

    public function __invoke(Command $command): void
    {
        $proposal = $this->proposals->get(new Id($command->id));
        $request = $proposal->getRequest();
        $proposal->score($command->score, $request->getCriteriaById($command->criteriaId));
        $this->flusher->flush();
    }
}
