<?php

declare(strict_types=1);

namespace App\Model\Procurement\Command\Request\AddCriteria;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Uuid;

class Command
{
    #[NotBlank]
    #[Uuid]
    public string $id;

    #[NotBlank]
    #[Length(max: 255)]
    public string $name = '';

    #[NotBlank]
    #[Range(min: 0, max: 100)]
    public float $weight = 0.0;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
