<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Supplier\Proposal;

use Webmozart\Assert\Assert;

class Status
{
    private const STATUS_WAIT = 'wait';
    private const STATUS_ACCEPTED = 'accepted';
    private const STATUS_REJECTED = 'rejected';

    public function __construct(private string $status)
    {
        Assert::inArray($this->status, self::all());
    }

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::STATUS_WAIT,
            self::STATUS_ACCEPTED,
            self::STATUS_REJECTED
        ];
    }

    public static function wait(): self
    {
        return new self(self::STATUS_WAIT);
    }

    public static function accept(): self
    {
        return new self(self::STATUS_ACCEPTED);
    }

    public static function reject(): self
    {
        return new self(self::STATUS_REJECTED);
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getValue(): string
    {
        return $this->status;
    }
}
