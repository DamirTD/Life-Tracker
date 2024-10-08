<?php

namespace App\Http\Controllers;

use App\Http\ServiceInterfaces\TransactionServiceInterface;
use App\Http\Utils\Constants\TransactionConstants;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService
    ) {
    }

    /**
     * @throws Exception
     */
    public function importPdf(Request $request): JsonResponse
    {
        $file      = $request->file('file');
        $pdfParser = new Parser();
        $pdfText   = $pdfParser->parseFile($file->getPathname())->getText();

        $transactions = array_filter(array_map(
            fn($line) => $this->transactionService->processLine($line),
            explode("\n", $pdfText)
        ));

        $sortedTransactions = $this->transactionService->sort(
            $transactions,
            $request->query('sortBy'),
            $request->query('sortOrder', 'desc')
        );

        return response()->json($sortedTransactions);
    }
}
