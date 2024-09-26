<?php

namespace Tests\Unit;

use App\Http\Services\TransactionService;
use App\Http\Utils\Enums\OperationType;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    protected TransactionService $transactionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionService = new TransactionService();
    }

    public function testGetOperationReturnsCorrectOperation()
    {
        $line = "Перевод 1000 ₸";
        $expected = OperationType::Transfer->value;
        $this->assertEquals($expected, $this->transactionService->getOperation($line));
    }

    public function testGetOperationReturnsNullWhenNoMatch()
    {
        $line = "Некорректная операция";
        $this->assertNull($this->transactionService->getOperation($line));
    }

    public function testGetAmountReturnsCorrectAmount()
    {
        $line = "Сумма: 1 500,00 ₸";
        $expectedAmount = "1500.00";
        $this->assertEquals($expectedAmount, $this->transactionService->getAmount($line));
    }

    public function testGetAmountReturnsNullWhenNoAmount()
    {
        $line = "Нет суммы в строке";
        $this->assertNull($this->transactionService->getAmount($line));
    }

    // Тесты для extractDetails()
    public function testExtractDetailsReturnsCorrectDetails()
    {
        $line = "Перевод 1000 ₸ на карту 1234";
        $expectedDetails = "1000 ₸ на карту 1234"; // Ожидаемое значение
        $this->assertEquals($expectedDetails, $this->transactionService->extractDetails($line));
    }

    public function testExtractDetailsReturnsEmptyStringWhenNoDetails()
    {
        $line = "Некорректная операция";
        $this->assertEquals('', $this->transactionService->extractDetails($line));
    }

    // Тесты для createTransaction()
    public function testCreateTransactionReturnsTransactionDTO()
    {
        $date = '2024-09-26';
        $operation = 'Перевод';
        $amount = '1000.00';
        $details = 'Оплата услуги';

        $transactionDTO = $this->transactionService->createTransaction($date, $operation, $amount, $details);

        $this->assertNotNull($transactionDTO);
        $this->assertEquals($date, $transactionDTO->date);
        $this->assertEquals($operation, $transactionDTO->operation);
        $this->assertEquals($amount, $transactionDTO->amount);
        $this->assertEquals($details, $transactionDTO->details);
    }

    public function testCreateTransactionReturnsNullWhenMissingOperationOrAmount()
    {
        $transactionDTO = $this->transactionService->createTransaction(null, 'Перевод', null, 'Оплата услуги');
        $this->assertNull($transactionDTO);

        $transactionDTO = $this->transactionService->createTransaction('2024-09-26', null, '1000.00', 'Оплата услуги');
        $this->assertNull($transactionDTO);
    }
}
