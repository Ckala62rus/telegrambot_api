<?php

namespace App\Contracts\TelegramBot;

use App\DTO\TelegramBotRequestDTO;

interface WarehouseServiceInterface
{
    /**
     * Regular expression '/^[0-9]{4,5}$/' => example '15278'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberCurrentYear(TelegramBotRequestDTO $data): array;

    /**
     * Regular expression '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/' => example '24%15278'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(TelegramBotRequestDTO $data): array;

    /**
     * Regular expression '/^([0-9]{4,5})[*]$/' => example '15278*'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear(TelegramBotRequestDTO $data): array;

    /**
     * Regular expression '/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/' => example '24%15278*'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(TelegramBotRequestDTO $data): array;

    /**
     * Regular expression '/^([0-9]{4,10})[@]$/' => example '15278@'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear(TelegramBotRequestDTO $data): array;

    /**
     * Regular expression '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/' => example '24%15278@'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(TelegramBotRequestDTO $data): array;

    /**
     * Send message to user about unknown command
     * @param TelegramBotRequestDTO $dtoInput
     * @return array
     */
    public function unknownCommand(TelegramBotRequestDTO $dtoInput): array;
}
