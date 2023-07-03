<?php

namespace App\DTO\Bills;

use App\Contracts\DTOInterface;
use App\Models\Bill;

final class InvoiceDTO implements DTOInterface
{
    protected function __construct(
        readonly protected string $name,
        readonly protected int    $hours,
        readonly protected int    $rate,
        readonly protected int    $amount,
        readonly protected string $date,
        readonly protected string $description,
        readonly protected int    $principal_id,
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
            name: $request['name'],
            hours: $request['hours'],
            rate: $request['rate'],
            amount: $request['amount'],
            date: $request['date'],
            description: $request['description'],
            principal_id: $request['principal_id'],
        );
    }

    public static function fromBill(Bill $bill): self
    {
        return new self(
            name: $bill->name,
            hours: $bill->hours,
            rate: $bill->rate,
            amount: $bill->amount,
            date: $bill->date,
            description: $bill->description,
            principal_id: $bill->principal_id,
        );
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return $this->hours;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @return int
     */
    public function getFullAmount(): int
    {
        return $this->hours * $this->rate;
    }
}
