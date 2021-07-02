<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Customer\Request;

use App\Model\Procurement\Entity\Customer\Request\Evaluation\Criteria;
use App\Model\Procurement\Entity\Customer\Request\Id;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Tests\Builder\Customer\CustomerBuilder;
use Monolog\Test\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = new Request(
            $id = Id::generate(),
            $customer = (new CustomerBuilder())->build(),
            $desc = '25 laptops needed',
            $date = new \DateTimeImmutable()
        );
        self::assertEquals($id, $request->getId());
        self::assertEquals($customer, $request->getCustomer());
        self::assertEquals($desc, $request->getDescription());
        self::assertEquals($date, $request->getCreatedAt());

        self::assertNotEmpty($request->getCriterias());
        self::assertArrayHasKey(0, $request->getCriterias());
        $criteria = $request->getCriterias()[0];
        self::assertEquals(Criteria::DEFAULT_NAME, $criteria->getName());
        self::assertEquals(Criteria::DEFAULT_PERCENT, $criteria->getPercent());
        self::assertEquals($request->getId(), $criteria->getRequest()->getId());
        self::assertNotEmpty($criteria->getId());
    }
}
