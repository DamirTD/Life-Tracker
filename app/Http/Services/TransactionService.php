<?php

namespace App\Http\Services;

use App\Http\ServiceInterfaces\TransactionServiceInterface;
use App\Http\Utils\Enums\OperationType;
use App\Http\Utils\DTO\TransactionDTO;

class TransactionService implements TransactionServiceInterface
{
    public function getOperation(string $line): ?string
    {
        foreach (OperationType::cases() as $operation) {
            if (str_contains($line, $operation->value)) {
                return $operation->value;
            }
        }
        return null;
    }

    public function getAmount(string $line): ?string
    {
        if (preg_match('/\d[\d\s]*[,\s]*\d{2}/', $line, $matches)) {
            $amount = str_replace([' ', ','], ['', '.'], $matches[0]);
            return number_format((float)$amount, 2, '.', '');
        }
        return null;
    }


    public function extractDetails(string $line): string
    {
        $pattern = '/(?:Перевод|Пополнение|Покупка)\s+(.+)$/u';
        if (preg_match($pattern, $line, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    public function createTransaction(?string $date, ?string $operation, ?string $amount, string $details): ?TransactionDTO
    {
        if(!isset($operation) || !isset($amount)){
            return null;
        }

        return new TransactionDTO($date, $operation, $amount, $details);
    }
}
