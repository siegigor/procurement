<?php

declare(strict_types=1);

namespace App\Tests\Builder\Customer;

use App\Model\Procurement\Entity\Customer\Customer\Customer;
use App\Model\Procurement\Entity\Customer\Request\Id;
use App\Model\Procurement\Entity\Customer\Request\Request;

class RequestBuilder
{
    private Id $id;
    private Customer $customer;
    private string $description;
    private \DateTimeImmutable $date;
    /** @var array<int, array{name: string, percent: float}>  */
    private array $criterias = [];

    public function __construct(?string $id = null, ?Customer $customer = null)
    {
        $this->id = $id ? new Id($id) : Id::generate();
        $this->customer = $customer ?: (new CustomerBuilder())->build();
        $this->description = '25 laptops needed';
        $this->date = new \DateTimeImmutable();
    }

    public function withCriteria(string $name, float $percent = 0.0): self
    {
        $clone = clone $this;
        $clone->criterias[] = ['name' => $name, 'percent' => $percent];
        return $clone;
    }

    public function build(): Request
    {
        $request = new Request($this->id, $this->customer, $this->description, $this->date);
        foreach ($this->criterias as $criteria) {
            $request->addCriteria($criteria['name'], $criteria['percent']);
        }
        return $request;
    }
}
