<?php

declare(strict_types=1);

namespace App\Tests\Builder\Customer;

use App\Model\Procurement\Entity\Customer\Customer\Customer;
use App\Model\Procurement\Entity\Customer\Customer\Id;

class CustomerBuilder
{
    private Id $id;
    private string $name;

    public function __construct(?string $id = null, ?string $name = null)
    {
        $this->id = $id ? new Id($id) : Id::generate();
        $this->name = $name ?: 'some name';
    }

    public function build(): Customer
    {
        return new Customer($this->id, $this->name);
    }
}
