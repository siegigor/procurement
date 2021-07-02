<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Request\Publish;

use App\Model\Flusher;
use App\Model\Procurement\Entity\Customer\Request\Id;
use App\Model\Procurement\Entity\Customer\Request\RequestRepository;

class Handler
{
    public function __construct(private RequestRepository $requests, private Flusher $flusher)
    {
    }

    public function __invoke(Command $command): void
    {
        $request = $this->requests->get(new Id($command->id));
        $request->publish();
        $this->flusher->flush();
    }
}
