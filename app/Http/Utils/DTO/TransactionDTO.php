<?php

namespace App\Http\Utils\DTO;

class TransactionDTO
{
    public function __construct(
        public ?string $date,
        public ?string $operation,
        public ?string $amount,
        public string $details
    ) {}

    public function toArray(): array
    {
        return [
            'date'      => $this->date,
            'operation' => $this->operation,
            'amount'    => $this->amount,
            'details'   => $this->details,
        ];
    }
}
