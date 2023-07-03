<?php

namespace App\Contracts;

interface DTOInterface
{
    /**
     * Return DTO from request
     *
     * @param array $request
     * @return $this
     */
    public static function fromRequest(array $request): self;
}
