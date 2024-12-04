<?php

namespace App\Contracts\TelegramBot;

interface WarehouseServiceInterface
{
    public function executeCommandFindCellByOnlyNumber(string $number): array;
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear($code): array;
    public function getCurrentYear(string $code): string;
}
