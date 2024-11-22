<?php

namespace App\Http\Utils\Enums;

enum TransactionOperationType: string
{
    case Purchase      = 'Покупка';
    case Replenishment = 'Пополнение';
    case Transfer      = 'Перевод';
}
