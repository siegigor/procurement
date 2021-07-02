<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Supplier\Proposal;

use App\Tests\Builder\Supplier\ProposalBuilder;
use Monolog\Test\TestCase;

class StatusTest extends TestCase
{
    public function testAcceptSuccess(): void
    {
        $proposal = (new ProposalBuilder())->build();
        $proposal->accept();
        self::assertTrue($proposal->isAccepted());
        self::assertFalse($proposal->isRejected());
        self::assertFalse($proposal->isWait());
    }

    public function testAcceptFailed(): void
    {
        $proposal = (new ProposalBuilder())->accepted()->build();
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Proposal is already accepted');
        $proposal->accept();
    }

    public function testRejectSuccess(): void
    {
        $proposal = (new ProposalBuilder())->build();
        $proposal->reject();
        self::assertTrue($proposal->isRejected());
        self::assertFalse($proposal->isAccepted());
        self::assertFalse($proposal->isWait());
    }

    public function testRejectFailed(): void
    {
        $proposal = (new ProposalBuilder())->rejected()->build();
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Proposal is already rejected');
        $proposal->reject();
    }
}
