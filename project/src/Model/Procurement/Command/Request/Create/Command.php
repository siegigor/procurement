<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Request\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class Command
{
    #[NotBlank]
    #[Uuid]
    public string $customerId;

    #[NotBlank]
    #[Uuid]
    public string $id;

    #[NotBlank]
    #[Length(max: 255)]
    public string $description = '';

    public function __construct(string $customerId, string $id)
    {
        $this->customerId = $customerId;
        $this->id = $id;
    }
}
