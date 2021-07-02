<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Customer;

interface CustomerRepository
{
    public function get(Id $id): Customer;

    public function add(Customer $customer): void;

    public function remove(Customer $customer): void;
}
