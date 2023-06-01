<?php

namespace App\Services\Expense\Exceptions;

use App\Exceptions\BaseException;
use Throwable;

class NotEnoughMoneyException extends BaseException
{
    public function __construct()
    {
        parent::__construct('Не достаточно средств на счёте');
    }
}
