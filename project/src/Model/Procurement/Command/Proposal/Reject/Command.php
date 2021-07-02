<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Reject;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class Command
{
    #[NotBlank]
    #[Uuid]
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
