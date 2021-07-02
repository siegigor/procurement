<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Supplier;

class Supplier
{
    private Id $id;
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
