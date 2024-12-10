<?php

namespace App\Contracts\TelegramBot;

interface WarehouseServiceInterface
{
    /**
     * Regular expression '/^[0-9]{4,5}$/' => example '15278'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberCurrentYear(string $code): array;

    /**
     * Regular expression '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/' => example '24%15278'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(string $code): array;

    /**
     * Regular expression '/^([0-9]{4,5})[*]$/' => example '15278*'
     * @param string $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear(string $code): array;

    /**
     * Regular expression '/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/' => example '24%15278*'
     * @param string $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(string $code): array;

    /**
     * Regular expression '/^([0-9]{4,10})[@]$/' => example '15278@'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear(string $code): array;

    /**
     * Regular expression '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/' => example '24%15278@'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(string $code): array;

    public function getCurrentYear(string $code): string;
}
