<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzeTransactionsRequest;
use App\Http\Requests\ImportPdfRequest;
use App\Http\ServiceInterfaces\TransactionAnalyzerServiceInterface;
use App\Http\ServiceInterfaces\TransactionServiceInterface;
use Exception;
use App\Http\Utils\Helper\TransactionPDFHelper;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface         $transactionService,
        protected TransactionPDFHelper                $transactionHelper,
        protected TransactionAnalyzerServiceInterface $transactionAnalyzerService
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

    public function analyze(AnalyzeTransactionsRequest $request): JsonResponse
    {
        $transactions = $request->transactions();

        $result = $this->transactionAnalyzerService->analyze($transactions);

        return response()->json($result);
    }
}
