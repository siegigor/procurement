<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Procurement\Entity\Supplier\Supplier;

use App\Model\Procurement\Entity\Supplier\Supplier\Id;
use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use App\Model\Procurement\Entity\Supplier\Supplier\SupplierRepository as SupplierRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class SupplierRepository implements SupplierRepositoryInterface
{
    /**
     * @var EntityRepository<Supplier>
     */
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Supplier::class);
    }

    public function get(Id $id): Supplier
    {
        /** @var Supplier $supplier */
        if (!$supplier = $this->repo->find($id)) {
            throw new EntityNotFoundException('Supplier is not found');
        }
        return $supplier;
    }

    public function add(Supplier $supplier): void
    {
        $this->em->persist($supplier);
    }

    public function remove(Supplier $supplier): void
    {
        $this->em->remove($supplier);
    }
}
