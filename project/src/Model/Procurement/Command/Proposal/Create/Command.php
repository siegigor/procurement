<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints\Valid;

class Command
{
    #[NotBlank]
    #[Uuid]
    public string $id;

    #[NotBlank]
    #[Uuid]
    public string $supplierId;

    #[NotBlank]
    #[Uuid]
    public string $requestId;

    #[NotBlank]
    #[Length(max: 255)]
    public string $description = '';

    /**
     * @var CriteriaValue[]
     */
    #[NotBlank]
    #[Valid]
    public array $criteriaValues = [];

    public function __construct(string $id, string $supplierId, string $requestId)
    {
        $this->id = $id;
        $this->supplierId = $supplierId;
        $this->requestId = $requestId;
    }
}
