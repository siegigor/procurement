<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Procurement\Entity\Customer\Request;

use App\Model\Procurement\Entity\Customer\Request\Id;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Customer\Request\RequestRepository as RequestRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class RequestRepository implements RequestRepositoryInterface
{
    /**
     * @var EntityRepository<Request>
     */
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Request::class);
    }

    public function get(Id $id): Request
    {
        /** @var Request $request */
        if (!$request = $this->repo->find($id)) {
            throw new EntityNotFoundException('Request is not found');
        }
        return $request;
    }

    public function add(Request $request): void
    {
        $this->em->persist($request);
    }

    public function remove(Request $request): void
    {
        $this->em->remove($request);
    }
}
