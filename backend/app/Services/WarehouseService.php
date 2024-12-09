<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Sql\SqlScripts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * Get part by number '/^[0-9]{4,5}$/'
     * @param string $number
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberCurrentYear(string $number): array
    {
        TimerExecuteService::Start();

        $data = $this->getPartyByNumber($this->getCurrentYear($number));

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        $timeExecute = TimerExecuteService::Stop();
        dd($data);
        return $data;
    }

    /**
     * Get party by number for another year '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/'
     * @param string $number
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(string $number): array
    {
        $data = $this->getPartyByNumber($number);
        dd($data);
    }

    /**
     * Get party by number
     * @param string $number
     * @return array
     */
    private function getPartyByNumber(string $number): array
    {
        return DB::connection("dax")
            ->select(SqlScripts::getSqlQuery(), [
                "number" => $number,
            ]);

    }

    /**
     * Get code with current year
     * @param string $code
     * @return string
     */
    public function getCurrentYear(string $code): string
    {
        $date = Carbon::now()->format("y");
        return $date . '%' . $code;
    }

    /**
     * Get part with color '/^([0-9]{4,5})[*]$/'
     * @param $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorCurrentYear($code): array
    {
        TimerExecuteService::Start();

        $sql = SqlScripts::getSqlQueryWithColor();

        $data = DB::connection("dax")->select($sql, [
            "number" => $this->getCurrentYear($code)
        ]);

        dd($data);

        $timeExecute = TimerExecuteService::Stop();

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }

    /**
     * Get party with color and user '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellWithColorAndUserAnotherYear(string $code): array
    {
        TimerExecuteService::Start();

        $sql = SqlScripts::getSqlQueryWithColor();

        $data = DB::connection("dax")->select($sql, ["number" => $code]);

        $timeExecute = TimerExecuteService::Stop();

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }
}
