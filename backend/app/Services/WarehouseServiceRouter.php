<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;
use App\DTO\TelegramBotRequestDTO;
use InvalidArgumentException;

class WarehouseServiceRouter implements WarehouseServiceRouterInterface
{
    /**
     * @param WarehouseServiceInterface $warehouseService
     */
    public function __construct(
        private WarehouseServiceInterface $warehouseService,
    ) {
    }

    /**
     * Create queue for execute command
     * @param array $data
     * @return array
     */
    public function router(array $data): array
    {
        $data = new TelegramBotRequestDTO($data);

        if (preg_match('/^[0-9]{4,5}$/', $data->getDirtyCode())) {
            $data->setCode($data->getDirtyCode());
            dump($data->getDirtyCode());
            return $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberCurrentYear($data);

            // todo send telegram response to user.

            return true;
        }

        if (preg_match('/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/', $data->getDirtyCode())) {
            dump($data->getDirtyCode());
            $data->setCode($data->getDirtyCode());
            $res = $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberAnotherYear($data);

            // todo send telegram response to user.

            return true;
        }

        if (preg_match('/^([0-9]{4,5})[*]$/', $data->getDirtyCode(), $match)) {
            dump($data->getDirtyCode());
            $data->setCode($match[1]);
            $res = $this
                ->warehouseService
                ->executeCommandFIndCellByOnlyNumberWithColorCurrentYear($data);

            // todo send telegram response to user.

            return true;
        }

        if (preg_match('/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/', $data->getDirtyCode(), $match)) {
            dump($data->getDirtyCode());
            $data->setCode($match[1]);
            $res = $this
                ->warehouseService
                ->executeCommandFIndCellByOnlyNumberWithColorAnotherYear($data);

            // todo send telegram response to user.

            return true;
        }

        if (preg_match('/^([0-9]{4,10})[@]$/', $data->getDirtyCode(), $match)) {
            dump($data->getDirtyCode());
            $data->setCode($match[1]);
            $res = $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear($data);

            // todo send telegram response to user.

            return true;
        }

        if (preg_match('/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/', $data->getDirtyCode(), $match)) {
            dump($data->getDirtyCode());
            $data->setCode($match[1]);
            $res = $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear($data);

            // todo send telegram response to user.

            return true;
        }

        dd('error');
        throw new InvalidArgumentException("Unknown command {$data->getDirtyCode()}");
    }
}
