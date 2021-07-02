<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Create;

use App\Model\Flusher;
use App\Model\Procurement\Entity\Customer\Request\Id as RequestId;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Customer\Request\RequestRepository;
use App\Model\Procurement\Entity\Supplier\Proposal\Id;
use App\Model\Procurement\Entity\Supplier\Proposal\Proposal;
use App\Model\Procurement\Entity\Supplier\Proposal\ProposalRepository;
use App\Model\Procurement\Entity\Supplier\Supplier\Id as SupplierId;
use App\Model\Procurement\Entity\Supplier\Supplier\SupplierRepository;
use App\Model\Procurement\Entity\Supplier\Proposal\CriteriaValue as CriteriaValueDomain;

class Handler
{
    public function __construct(
        private ProposalRepository $proposals,
        private SupplierRepository $suppliers,
        private RequestRepository $requests,
        private Flusher $flusher
    ) {
    }

    public function __invoke(Command $command): void
    {
        $supplier = $this->suppliers->get(new SupplierId($command->supplierId));
        $request = $this->requests->get(new RequestId($command->requestId));

        $criteriasValues = $this->getCriterias($request, $command->criteriaValues);
        $proposal = new Proposal(
            new Id($command->id),
            $supplier,
            $request,
            $command->description,
            new \DateTimeImmutable(),
            $criteriasValues
        );
        $this->proposals->add($proposal);
        $this->flusher->flush();
    }

    /**
     * @param CriteriaValue[] $values
     * @return CriteriaValueDomain[]
     */
    private function getCriterias(Request $request, array $values): array
    {
        $criteriasValues = [];
        foreach ($values as $value) {
            $criteriasValues[] = new CriteriaValueDomain($request->getCriteriaById($value->criteriaId), $value->value);
        }
        return $criteriasValues;
    }
}
