<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Customer\Customer;

use App\Model\Procurement\Entity\Customer\Customer\Customer;
use App\Model\Procurement\Entity\Customer\Customer\Id;
use Monolog\Test\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $customer = new Customer(
            $id = new Id('18c8f084-ee11-4be3-8e23-d72c3e31094e'),
            $name = 'some business name'
        );
        self::assertEquals($id, $customer->getId());
        self::assertEquals($name, $customer->getBusinessName());
    }
}
