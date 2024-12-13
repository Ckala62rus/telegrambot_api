<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;

class WarehouseServiceRouter implements WarehouseServiceRouterInterface
{
    /**
     * @param WarehouseServiceInterface $warehouseService
     */
    public function __construct(
        private WarehouseServiceInterface $warehouseService,
    ){}

    /**
     * create queue for execute command
     * @param array $request
     * @return bool
     */
    public function router(array $request): bool
    {
        $data = $request;

        if ( preg_match('/^[0-9]{4,5}$/', $data["code_for_looking"]) ) {
            dump($data["code_for_looking"]);
            $res = $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberCurrentYear($data['code_for_looking']);

            // todo send telegram response to user.

            return true;
        }

        if ( preg_match('/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/', $data["code_for_looking"]) ) {
            dump($data["code_for_looking"]);
            $res = $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberAnotherYear($data['code_for_looking']);

            // todo send telegram response to user.

            return true;
        }

        if ( preg_match('/^([0-9]{4,5})[*]$/', $data["code_for_looking"], $match) ) {
            dump($match);
            $res = $this
                ->warehouseService
                ->executeCommandFIndCellByOnlyNumberWithColorCurrentYear($match[1]);

            // todo send telegram response to user.

            return true;
        }

        throw new \InvalidArgumentException("Unknown command {$data["code_for_looking"]}");
    }
}
