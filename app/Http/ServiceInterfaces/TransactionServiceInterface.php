<?php

namespace App\Http\ServiceInterfaces;

use App\Http\Utils\DTO\TransactionDTO;

interface TransactionServiceInterface
{
    public function getOperation(string $line): ?string;

    public function getAmount(string $line): ?string;

    public function extractDetails(string $line): string;

    public function createTransaction(?string $date, ?string $operation, ?string $amount, string $details): ?TransactionDTO;

    public function sort(array $transactions, ?string $sortBy, string $sortOrder = 'desc'): array;
}
