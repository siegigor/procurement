<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Procurement\Entity\Supplier\Proposal;

use App\Model\Procurement\Entity\Supplier\Proposal\Id;
use App\Model\Procurement\Entity\Supplier\Proposal\Proposal;
use App\Model\Procurement\Entity\Supplier\Proposal\ProposalRepository as ProposalRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class ProposalRepository implements ProposalRepositoryInterface
{
    /**
     * @var EntityRepository<Proposal>
     */
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Proposal::class);
    }

    public function get(Id $id): Proposal
    {
        /** @var Proposal $proposal */
        if (!$proposal = $this->repo->find($id)) {
            throw new EntityNotFoundException('Proposal is not found');
        }
        return $proposal;
    }

    public function add(Proposal $proposal): void
    {
        $this->em->persist($proposal);
    }

    public function remove(Proposal $proposal): void
    {
        $this->em->remove($proposal);
    }
}
