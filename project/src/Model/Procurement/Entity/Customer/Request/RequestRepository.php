<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Request;

interface RequestRepository
{
    public function get(Id $id): Request;

    public function add(Request $request): void;

    public function remove(Request $request): void;
}
