<?php

namespace App\Http\Services;

use App\Http\ServiceInterfaces\TransactionAnalyzerServiceInterface;
use App\Http\Utils\Enums\TransactionOperationType;
use App\Http\Utils\Helper\TransactionAnalyzerHelper;

class TransactionAnalyzerService implements TransactionAnalyzerServiceInterface
{

    public function __construct(
        protected TransactionAnalyzerHelper $transactionAnalyzerHelper
    ) {
    }

    public function analyze(array $transactions): array
    {
        $counts        = $this->transactionAnalyzerHelper->initializeOperationArrays();
        $sums          = $this->transactionAnalyzerHelper->initializeOperationArrays();
        $maxOperations = $this->transactionAnalyzerHelper->initializeMaxOperations();

        foreach ($transactions as $transaction) {
            $operation = $transaction['operation'];
            $amount    = (float) $transaction['amount'];
            $details   = $transaction['details'];

            if (TransactionOperationType::tryFrom($operation)) {
                $this->transactionAnalyzerHelper->processTransaction($operation, $details, $amount, $counts, $sums);
            }
            $this->transactionAnalyzerHelper->updateMaxAmounts($operation, $amount, $details, $maxOperations);
        }
        return $this->transactionAnalyzerHelper->formatResult($counts, $sums, $maxOperations);
    }
}
