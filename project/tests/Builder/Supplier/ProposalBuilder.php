<?php

declare(strict_types=1);

namespace App\Tests\Builder\Supplier;

use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Supplier\Proposal\CriteriaValue;
use App\Model\Procurement\Entity\Supplier\Proposal\Id;
use App\Model\Procurement\Entity\Supplier\Proposal\Proposal;
use App\Model\Procurement\Entity\Supplier\Proposal\Status;
use App\Model\Procurement\Entity\Supplier\Supplier\Supplier;
use App\Tests\Builder\Customer\RequestBuilder;

class ProposalBuilder
{
    private Id $id;
    private Supplier $supplier;
    private Request $request;
    private ?Status $status = null;

    public function __construct(?string $id = null, ?Supplier $supplier = null, ?Request $request = null)
    {
        $this->id = $id ? new Id($id) : Id::generate();
        $this->supplier = $supplier ?: (new SupplierBuilder())->build();
        $this->request = $request ?: (new RequestBuilder())->build();
    }

    public function accepted(): self
    {
        $clone = clone $this;
        $clone->status = Status::accept();
        return $clone;
    }

    public function rejected(): self
    {
        $clone = clone $this;
        $clone->status = Status::reject();
        return $clone;
    }

    public function build(): Proposal
    {
        $criteriasValues = [];
        foreach ($this->request->getCriterias() as $criteria) {
            $criteriasValues[] = new CriteriaValue($criteria, $criteria->getId() . 'val');
        }
        $proposal = new Proposal(
            $this->id,
            $this->supplier,
            $this->request,
            'some desc',
            new \DateTimeImmutable(),
            $criteriasValues
        );
        if ($this->status && $this->status->isAccepted()) {
            $proposal->accept();
        }
        if ($this->status && $this->status->isRejected()) {
            $proposal->reject();
        }
        return $proposal;
    }
}
