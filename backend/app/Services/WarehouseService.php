<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Sql\SqlScripts;
use Illuminate\Support\Facades\DB;

class WarehouseService implements WarehouseServiceInterface
{
    /**
     * Get part by number
     * @param string $number
     * @return void
     */
    public function executeCommandFindCellByOnlyNumber(string $number): void
    {
        TimerExecuteService::Start();

        $sql = SqlScripts::getSqlQuery();

        $data = DB::connection("dax")->select($sql, ["number" => $number]);

        $time = TimerExecuteService::Stop();

        dd($time);
    }
}
