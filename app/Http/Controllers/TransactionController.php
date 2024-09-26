<?php

namespace App\Http\Controllers;

use App\Http\ServiceInterfaces\TransactionServiceInterface;
use App\Http\Utils\Constants\TransactionConstants;
use App\Http\Utils\Enums\OperationType;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService
    )
    {
    }

    /**
     * @throws Exception
     */
    public function importPdf(Request $request): JsonResponse
    {
        $file      = $request->file('file');
        $pdfParser = new Parser();
        $pdf       = $pdfParser->parseFile($file->getPathname());
        $lines     = explode("\n", $pdf->getText());

        $transactions = [];

        foreach ($lines as $line) {
            if (preg_match(TransactionConstants::DATE_PATTERN, $line, $dateMatches)) {

                $date      = $dateMatches[0];

                $operation   = $this->transactionService->getOperation($line);
                $amount      = $this->transactionService->getAmount($line);
                $details     = $this->transactionService->extractDetails($line);
                $transaction = $this->transactionService->createTransaction($date, $operation, $amount, $details);

                if ($transaction) {
                    $transactions[] = $transaction->toArray();
                }
            }
        }
        return response()->json($transactions);
    }
}
