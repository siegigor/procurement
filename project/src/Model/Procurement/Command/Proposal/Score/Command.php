<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Score;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Uuid;

class Command
{
    #[NotBlank]
    #[Uuid]
    public string $id;

    #[NotBlank]
    #[Uuid]
    public string $criteriaId;

    #[NotBlank]
    #[Range(min: 1, max: 100)]
    public int $score = 0;

    public function __construct(string $id, string $criteriaId)
    {
        $this->id = $id;
        $this->criteriaId = $criteriaId;
    }
}
