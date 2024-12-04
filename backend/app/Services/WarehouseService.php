<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Sql\SqlScripts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * Get part by number
     * @param string $number
     * @return array
     */
    public function executeCommandFindCellByOnlyNumber(string $number): array
    {
        TimerExecuteService::Start();

        $sql = SqlScripts::getSqlQuery();
        $data = DB::connection("dax")
            ->select($sql, [
                "number" => $this->getCurrentYear($number),
            ]);

        //партия может быть не найдена!
        if (!$data) {
            return [];
        }

        $timeExecute = TimerExecuteService::Stop();
        dd($data);
        return $data;
    }

    /**
     * Get code with current year
     * @param string $code
     * @return string
     */
    public function getCurrentYear(string $code): string
    {
        $date = Carbon::now()->format("Y");
        return $date[2] . $date[3] . '%' . $code;
    }
}
