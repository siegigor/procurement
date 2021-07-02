<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Request\Evaluation;

use App\Model\Procurement\Entity\Customer\Request\Request;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "procurement_request_criterias")]
class Criteria
{
    public const DEFAULT_NAME = 'price';
    public const DEFAULT_PERCENT = 100.0;

    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\ManyToOne(inversedBy: "criterias")]
    #[ORM\JoinColumn(name: "request_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Request $request;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private float $percent;

    public function __construct(Request $request, string $name, float $percent)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->request = $request;
        $this->name = $name;
        $this->percent = $percent;
    }

    public function isSameByName(string $name): bool
    {
        return $this->name === $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }
}
