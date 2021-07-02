<?php

declare(strict_types=1);

namespace App\Tests\Builder\Supplier;

use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use App\Model\Procurement\Entity\Supplier\Supplier\Id;

class SupplierBuilder
{
    private Id $id;
    private string $name;

    public function __construct(?string $id = null, ?string $name = null)
    {
        $this->id = $id ? new Id($id) : Id::generate();
        $this->name = $name ?: 'some name';
    }

    public function build(): Supplier
    {
        return new Supplier($this->id, $this->name);
    }
}
