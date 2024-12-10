<?php

namespace App\Contracts\TelegramBot;

interface WarehouseServiceInterface
{
    public function executeCommandFindCellByOnlyNumberCurrentYear(string $code): array;
    public function executeCommandFindCellByOnlyNumberAnotherYear(string $code): array;

    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear(string $code): array;
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(string $code): array;

    public function executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear(string $code): array;
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(string $code): array;

    public function getCurrentYear(string $code): string;
}
