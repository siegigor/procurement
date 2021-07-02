<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Supplier\Supplier;

use App\Model\Procurement\Entity\Supplier\Supplier\Id;
use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use Monolog\Test\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $supplier = new Supplier(
            $id = new Id('18c8f084-ee11-4be3-8e23-d72c3e31094e'),
            $name = 'some business name'
        );
        self::assertEquals($id, $supplier->getId());
        self::assertEquals($name, $supplier->getBusinessName());
    }
}
