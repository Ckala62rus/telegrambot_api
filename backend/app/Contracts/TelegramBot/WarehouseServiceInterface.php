<?php

namespace App\Contracts\TelegramBot;

interface WarehouseServiceInterface
{
    public function executeCommandFindCellByOnlyNumber(string $number): void;
}
