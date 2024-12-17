<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Sql\SqlScripts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * Get part by number '/^[0-9]{4,5}$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberCurrentYear(string $code): array
    {
        dump('executeCommandFindCellByOnlyNumberCurrentYear');
        $data = $this->executor(array($this, 'getPartyByNumber'), $this->getCurrentYear($code));

        dd($data);
        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        return $data;
    }

    /**
     * Get party by number for another year '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(string $code): array
    {
        dump('executeCommandFindCellByOnlyNumberAnotherYear');
        $data = $this->executor(array($this, 'getPartyByNumber'), $code);
        dd($data);
    }

    /**
     * Get part with color '/^([0-9]{4,5})[*]$/'
     * @param $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear($code): array
    {
        dump('executeCommandFIndCellByOnlyNumberWithColorCurrentYear');
        $data = $this->executor(array($this, 'getPartyByNumberWithColor'), $this->getCurrentYear($code));
        dd($data);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }

    /**
     * Get party with color and user '/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(string $code): array
    {
        dump('executeCommandFIndCellByOnlyNumberWithColorAnotherYear');
        $data = $this->executor(array($this, 'getPartyByNumberWithColor'), $code);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }

    /**
     * Get party by number with color and user for current year '/^([0-9]{4,10})[@]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear(string $code): array
    {
        dump('executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear');
        $data = $this->executor(array($this, 'getPartByNumberWithColorAndUser'), $this->getCurrentYear($code));

        dd($data);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        return $data;
    }

    /**
     * Get party by number with color and user for current year '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(string $code): array
    {
        $data = $this->executor(array($this, 'getPartByNumberWithColorAndUser'), $code);

        dd($data);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }
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
        $date = Carbon::now()->format("y");
        return $date . '%' . $code;
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
}
