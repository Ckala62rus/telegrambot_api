<?php

namespace App\Services;

use App\Contracts\TelegramBot\TelegramNotificationServiceInterface;
use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\DTO\TelegramBotOutResponse;
use App\DTO\TelegramBotRequestDTO;
use App\Sql\SqlScripts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * @var string
     */
    private string $NOT_FOUND_PART_MASSAGE = 'партия не найдена';

    /**
     * @param TelegramNotificationServiceInterface $telegramNotificationService
     */
    public function __construct(
        private TelegramNotificationServiceInterface $telegramNotificationService
    ) {
    }

    /**
     * Get part by number '/^[0-9]{4,5}$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberCurrentYear(TelegramBotRequestDTO $data): array
    {
        $result = $this
            ->executor(
                [$this, 'getPartyByNumber'],
                $this->getCurrentYear($data->getCode())
            );

        return $this->processingResult(
            dataFromDatabase: $result,
            dtoInput: $data,
        );
    }

    /**
     * Get party by number for another year '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(TelegramBotRequestDTO $data): array
    {
        $result = $this->executor(array($this, 'getPartyByNumber'), $data->getCode());

        return $this->processingResult(
            dataFromDatabase: $result,
            dtoInput: $data,
        );
    }

    /**
     * Get part with color '/^([0-9]{4,5})[*]$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear(TelegramBotRequestDTO $data): array
    {
        $result = $this->executor(array($this, 'getPartyByNumberWithColor'), $this->getCurrentYear($data->getCode()));

        return $this->processingResult(
            dataFromDatabase: $result,
            dtoInput: $data,
            additionalFields: ['CONFIGID', 'COLORID']
        );
    }

    /**
     * Get party with color and user '/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(TelegramBotRequestDTO $data): array
    {
        $result = $this->executor(array($this, 'getPartyByNumberWithColor'), $data->getCode());

        return $this->processingResult(
            dataFromDatabase: $result,
            dtoInput: $data,
            additionalFields: ['CONFIGID', 'COLORID']
        );
    }

    /**
     * Get party by number with color and user for current year '/^([0-9]{4,10})[@]$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear(TelegramBotRequestDTO $data): array
    {
        $result = $this
            ->executor(
                [$this, 'getPartByNumberWithColorAndUser'],
                $this->getCurrentYear($data->getCode())
            );

        return $this->processingResult(
            dataFromDatabase: $result,
            dtoInput: $data,
            additionalFields: ['COLORID', 'USERNAME']
        );
    }

    /**
     * Get party by number with color and user for current year '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/'
     * @param TelegramBotRequestDTO $data
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(TelegramBotRequestDTO $data): array
    {
        $result = $this
            ->executor(
                [$this, 'getPartByNumberWithColorAndUser'],
                $data->getCode()
            );

        return $this
            ->processingResult(
                dataFromDatabase: $result,
                dtoInput: $data,
                additionalFields: ['COLORID', 'USERNAME']
            );
    }

    /**
     * Get party by number
     * @param string $code
     * @return array
     */
    private function getPartyByNumber(string $code): array
    {
        return DB::connection("dax")
            ->select(SqlScripts::getSqlQuery(), [
                "number" => $code,
            ]);
    }

    /**
     * Get code with current year
     * @param string $code
     * @return string
     */
    private function getCurrentYear(string $code): string
    {
        return Carbon::now()->format("y") . '%' . $code;
    }

    /**
     * Get part by number with color
     * @param string $code
     * @return array
     */
    private function getPartyByNumberWithColor(string $code): array
    {
        return DB::connection("dax")
            ->select(SqlScripts::getSqlQueryWithColor(), [
                "number" => $code
            ]);
    }

    /**
     * Get part by number with color and user
     * @param string $code
     * @return array
     */
    private function getPartByNumberWithColorAndUser(string $code): array
    {
        return DB::connection("dax")->select(
            SqlScripts::getSqlQueryByPartialWithUsers(),
            ["number" => $code],
        );
    }

    /**
     * Executor for other commands
     * @param callable $fnc
     * @param string $param
     * @return array
     */
    #[ArrayShape(['execute_time' => "int", 'data' => "mixed"])]
    private function executor(callable $fnc, string $param): array
    {
        TimerExecuteService::Start();

        $result = $fnc($param);

        $timeExecute = TimerExecuteService::Stop();

        return [
            'execute_time' => $timeExecute,
            'data' => $result,
        ];
    }

    /**
     * processing result and send notification
     * @param array $dataFromDatabase
     * @param TelegramBotRequestDTO $dtoInput
     * @param array $additionalFields
     * @return array
     */
    public function processingResult(
        array $dataFromDatabase,
        TelegramBotRequestDTO $dtoInput,
        array $additionalFields = []
    ): array {
        if (!$dataFromDatabase['data']) {
            $this
                ->telegramNotificationService
                ->sendMessageToTelegram(
                    message: $this->NOT_FOUND_PART_MASSAGE . ' ' . $dtoInput->getCode(),
                    id_user: $dtoInput->getTelegramUserId()
                );
            return [];
        }

        $dtoOutput = new TelegramBotOutResponse(
            data: $dataFromDatabase,
            someField: $additionalFields
        );

        $message = $dtoOutput->getCellByOnlyNumberCurrentYear();

        $this
            ->telegramNotificationService
            ->sendMessageToTelegram(
                message: $message,
                id_user: $dtoInput->getTelegramUserId()
            );

        return $dataFromDatabase;
    }

    /**
     * Send message to user about unknown command
     * @param TelegramBotRequestDTO $dtoInput
     * @return array
     */
    public function unknownCommand(TelegramBotRequestDTO $dtoInput): array
    {
        $this
            ->telegramNotificationService
            ->sendMessageToTelegram(
                message: "Некорректные данные",
                id_user: $dtoInput->getTelegramUserId()
            );

        return [];
    }
}
