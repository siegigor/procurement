<?php

declare(strict_types=1);

namespace App\Infrastructure\Model\Procurement\Entity\Customer\Customer;

use App\Model\Procurement\Entity\Customer\Customer\Customer;
use App\Model\Procurement\Entity\Customer\Customer\CustomerRepository as CustomerRepositoryInterface;
use App\Model\Procurement\Entity\Customer\Customer\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var EntityRepository<Customer>
     */
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Customer::class);
    }

    public function get(Id $id): Customer
    {
        /** @var Customer $customer */
        if (!$customer = $this->repo->find($id)) {
            throw new EntityNotFoundException('Customer is not found');
        }
        return $customer;
    }

    public function add(Customer $customer): void
    {
        $this->em->persist($customer);
    }

    public function remove(Customer $customer): void
    {
        $this->em->remove($customer);
    }
}
