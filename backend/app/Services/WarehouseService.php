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
//        TimerExecuteService::Start();
        dump('executeCommandFindCellByOnlyNumberCurrentYear');
//        $data = $this->getPartyByNumber($this->getCurrentYear($number));
        $data = $this->executor(array($this, 'getPartyByNumber'), $this->getCurrentYear($number));

        dd($data);
        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

//        $timeExecute = TimerExecuteService::Stop();
        return $data;
    }

    /**
     * Get party by number for another year '/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/'
     * @param string $number
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberAnotherYear(string $number): array
    {
        dump('executeCommandFindCellByOnlyNumberAnotherYear');
//        $data = $this->getPartyByNumber($number);
        $data = $this->executor(array($this, 'getPartyByNumber'), $number);
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
//        TimerExecuteService::Start();

//        $sql = SqlScripts::getSqlQueryWithColor();
//        $data = DB::connection("dax")->select($sql, [
//            "number" => $this->getCurrentYear($code)
//        ]);

//        $data = $this->getPartyByNumberWithColor($this->getCurrentYear($code));
        $data = $this->executor(array($this, 'getPartyByNumberWithColor'), $this->getCurrentYear($code));

//        $timeExecute = TimerExecuteService::Stop();

        dd($data);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }

    /**
     * Executor for other commands
     * @param callable $fnc
     * @param string $param
     * @return array
     */
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
     * Get party with color and user '/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFIndCellByOnlyNumberWithColorAnotherYear(string $code): array
    {
        dump('executeCommandFIndCellByOnlyNumberWithColorAnotherYear');
//        TimerExecuteService::Start();

//        $sql = SqlScripts::getSqlQueryWithColor();
//        $data = DB::connection("dax")->select($sql, ["number" => $code]);

//        $data = $this->getPartyByNumberWithColor($code);
        $data = $this->executor(array($this, 'getPartyByNumberWithColor'), $code);

//        $timeExecute = TimerExecuteService::Stop();

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
        TimerExecuteService::Start();

        $data = $this->getPartByNumberWithColorAndUser($this->getCurrentYear($code));

        $timeExecute = TimerExecuteService::Stop();

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        dd($data);
    }

    /**
     * Get party by number with color and user for current year '/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/'
     * @param string $code
     * @return array
     */
    public function executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear(string $code): array
    {
        TimerExecuteService::Start();

        $data = $this->getPartByNumberWithColorAndUser($code);

        $timeExecute = TimerExecuteService::Stop();
        dd($data);
        //партия может быть не найдена!
        if (!$data) {
            return [];
        }
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
}
