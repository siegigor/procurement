<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Customer;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "procurement_customers")]
class Customer
{
    #[ORM\Id]
    #[ORM\Column(type: 'procurement_customer_id')]
    private Id $id;

    #[ORM\Column]
    private string $businessName;

    public function __construct(Id $id, string $businessName)
    {
        $this->id = $id;
        $this->businessName = $businessName;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getBusinessName(): string
    {
        return $this->businessName;
    }
}
