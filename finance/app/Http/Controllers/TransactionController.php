<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportPdfRequest;
use App\Http\ServiceInterfaces\TransactionServiceInterface;
use Exception;
use App\Http\Utils\ServiceHelper\TransactionHelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService,
        protected TransactionHelperService $transactionHelper
    ) {
    }

    /**
     * @throws Exception
     */
    public function importPdf(ImportPdfRequest $request): JsonResponse
    {
        $file      = $request->file('file');
        $sortBy    = $request->getSortBy();
        $sortOrder = $request->getSortOrder();

        $transactions = $this->transactionHelper->processPdfTransactions($file, $this->transactionService, $sortBy, $sortOrder);
        $summary      = $this->transactionHelper->calculateSummary($transactions);

        return response()->json([
            'summary'      => $summary,
            'transactions' => array_values($transactions),
        ]);
    }
}
