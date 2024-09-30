<?php

namespace App\Http\Services;

use App\Http\ServiceInterfaces\TransactionServiceInterface;
use App\Http\Utils\Constants\TransactionConstants;
use App\Http\Utils\Enums\OperationType;
use App\Http\Utils\DTO\TransactionDTO;
use App\Http\Utils\Sort\TransactionSorter;

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

    public function sort(array $transactions, ?string $sortBy, string $sortOrder = 'desc'): array
    {
        if (isset($sortBy)) {
            return TransactionSorter::sort($transactions, $sortBy, $sortOrder);
        }
        return $transactions;
    }

    public function processLine(string $line): ?array
    {
        if (preg_match(TransactionConstants::DATE_PATTERN, $line, $dateMatches)) {
            $date        = $dateMatches[0];
            $operation   = $this->getOperation($line);
            $amount      = $this->getAmount($line);
            $details     = $this->extractDetails($line);
            $transaction = $this->createTransaction($date, $operation, $amount, $details);

            return $transaction?->toArray();
        }
        return null;
    }
}
