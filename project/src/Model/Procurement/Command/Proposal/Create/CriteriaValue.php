<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Proposal\Create;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class CriteriaValue
{
    #[NotBlank]
    #[Uuid]
    public string $criteriaId = '';

    #[NotBlank]
    public string $value = '';
}
