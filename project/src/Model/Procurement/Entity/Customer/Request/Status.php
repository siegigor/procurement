<?php

declare(strict_types=1);

namespace App\Model\Procurement\Entity\Customer\Request;

use Webmozart\Assert\Assert;

class Status
{
    private const STATUS_DRAFT = 'draft';
    private const STATUS_PUBLISHED = 'published';

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
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED
        ];
    }

    public static function draft(): self
    {
        return new self(self::STATUS_DRAFT);
    }

    public static function publish(): self
    {
        return new self(self::STATUS_PUBLISHED);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function getValue(): string
    {
        return $this->status;
    }
}
