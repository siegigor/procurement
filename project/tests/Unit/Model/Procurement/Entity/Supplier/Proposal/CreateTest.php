<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Supplier\Proposal;

use App\Model\Procurement\Entity\Supplier\Proposal\CriteriaValue;
use App\Model\Procurement\Entity\Supplier\Proposal\Id;
use App\Model\Procurement\Entity\Supplier\Proposal\Proposal;
use App\Tests\Builder\Customer\RequestBuilder;
use App\Tests\Builder\Supplier\SupplierBuilder;
use Monolog\Test\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = (new RequestBuilder())->withCriteria('processor')->build();
        $criteriasValues = [];
        foreach ($request->getCriterias() as $criteria) {
            $criteriasValues[] = new CriteriaValue($criteria, $criteria->getId() . 'val');
        }
        $proposal = new Proposal(
            $id = Id::generate(),
            $supplier = (new SupplierBuilder())->build(),
            $request,
            $description = 'Dell – i7, Quadcore 2,3 GHz',
            $date = new \DateTimeImmutable(),
            $criteriasValues
        );
        self::assertEquals($id, $proposal->getId());
        self::assertEquals($supplier->getId(), $proposal->getSupplier()->getId());
        self::assertEquals($request->getId(), $proposal->getRequest()->getId());
        self::assertEquals($description, $proposal->getDescription());
        self::assertEquals($date, $proposal->getCreatedAt());
        self::assertTrue($proposal->isWait());
        self::assertFalse($proposal->isRejected());
        self::assertFalse($proposal->isAccepted());

        self::assertNotEmpty($proposal->getScores());
        foreach ($request->getCriterias() as $key => $criteria) {
            self::assertArrayHasKey($key, $proposal->getScores());
            $score = $proposal->getScores()[$key];
            self::assertEquals($criteria, $score->getCriteria());
            self::assertEquals(0, $score->getScore()->getValue());
            self::assertEquals($criteria->getId() . 'val', $score->getValue());
            self::assertNotEmpty($score->getId());
        }
    }
}
