<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Request\Create;

use App\Model\Flusher;
use App\Model\Procurement\Entity\Customer\Customer\CustomerRepository;
use App\Model\Procurement\Entity\Customer\Customer\Id;
use App\Model\Procurement\Entity\Customer\Request\Id as RequestId;
use App\Model\Procurement\Entity\Customer\Request\Request;
use App\Model\Procurement\Entity\Customer\Request\RequestRepository;

class Handler
{
    public function __construct(
        private RequestRepository $requests,
        private CustomerRepository $customers,
        private Flusher $flusher
    ) {
    }

    public function __invoke(Command $command): void
    {
        $customer = $this->customers->get(new Id($command->customerId));
        $request = new Request(
            new RequestId($command->id),
            $customer,
            $command->description,
            new \DateTimeImmutable()
        );
        $this->requests->add($request);
        $this->flusher->flush();
    }
}
