<?php

namespace App\DTO;

use App\Contracts\DTOInterface;

class TimeFiltersDTO implements DTOInterface
{
    public function __construct(
        readonly protected ?string $startedToDate,
        readonly protected ?string $startedFromDate,
    ) {}

    /**
     * Return DTO from request
     *
     * @param array $request
     * @return $this
     */
    public static function fromRequest(array $request): self
    {
        return new self(
            startedToDate: $request['startedToDate'] ?? null,
            startedFromDate: $request['startedFromDate'] ?? null,
        );
    }

    /**
     * Get the value of startedFromDate
     */
    public function getStartedToDate(): ?string
    {
        return $this->startedToDate;
    }

    /**
     * Get the value of startedFromDate
     */
    public function getStartedFromDate(): ?string
    {
        return $this->startedFromDate;
    }
}
