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

        $totalSpent = 0;
        $totalReceived = 0;
        $dates = [];

        foreach ($sortedTransactions as $transaction) {
            $dates[] = $transaction['date'];

            if (in_array($transaction['operation'], ['Перевод', 'Покупка'])) {
                $totalSpent += (float)$transaction['amount'];
            } elseif ($transaction['operation'] === 'Пополнение') {
                $totalReceived += (float)$transaction['amount'];
            }
        }

        $startDate = min($dates);
        $endDate = max($dates);

        $response = [
            'summary' => [
                'total_spent' => number_format($totalSpent, 2, '.', ''),
                'total_received' => number_format($totalReceived, 2, '.', ''),
                'period' => "{$startDate} - {$endDate}"
            ],
            'transactions' => array_values($sortedTransactions)
        ];

        return response()->json($response);
    }
}
