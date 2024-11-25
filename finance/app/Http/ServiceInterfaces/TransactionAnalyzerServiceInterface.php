<?php

namespace App\Http\ServiceInterfaces;

interface TransactionAnalyzerServiceInterface
{
    public function analyze(array $transactions): array;
}
