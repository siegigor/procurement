<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Supplier\Proposal;

use App\Tests\Builder\Customer\RequestBuilder;
use App\Tests\Builder\Supplier\ProposalBuilder;
use Monolog\Test\TestCase;

class ScoreTest extends TestCase
{
    public function testScoreSuccess(): void
    {
        $request = (new RequestBuilder())->withCriteria('some')->build();
        $proposal = (new ProposalBuilder(null, null, $request))->build();
        $criteria = $request->getCriterias()[1];
        $proposal->score($value = 50, $criteria);
        $score = $proposal->getCriteriaScore($criteria);
        self::assertEquals($value, $score->getScore()->getValue());
    }

    public function testFailedByGreaterThanLimit(): void
    {
        $proposal = (new ProposalBuilder())->build();
        $this->expectException(\InvalidArgumentException::class);
        $proposal->score(101, $proposal->getRequest()->getCriterias()[0]);
    }

    public function testFailedByLessThanLimit(): void
    {
        $proposal = (new ProposalBuilder())->build();
        $this->expectException(\InvalidArgumentException::class);
        $proposal->score(-1, $proposal->getRequest()->getCriterias()[0]);
    }

    public function testFailedByCriteria(): void
    {
        $proposal1 = (new ProposalBuilder())->build();
        $proposal2 = (new ProposalBuilder())->build();
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Criteria is not found in the Proposal');
        $proposal1->score(50, $proposal2->getRequest()->getCriterias()[0]);
    }
}
