<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Supplier;

interface SupplierRepository
{
    public function get(Id $id): Supplier;

    public function add(Supplier $supplier): void;

    public function remove(Supplier $supplier): void;
}
