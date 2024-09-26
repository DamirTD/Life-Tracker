<?php

namespace App\Http\Utils\Enums;

enum OperationType: string
{
    case Purchase = 'Покупка';
    case Replenishment = 'Пополнение';
    case Transfer = 'Перевод';
}
