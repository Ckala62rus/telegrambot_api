<?php

namespace App\Services;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;
use App\DTO\TelegramBotRequestDTO;

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
            return $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberCurrentYear($data);
        }

        if (preg_match('/^[0-9]{1,2}[%]{1}[0-9]{4,5}$/', $data->getDirtyCode())) {
            $data->setCode($data->getDirtyCode());
            return $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberAnotherYear($data);
        }

        if (preg_match('/^([0-9]{4,5})[*]$/', $data->getDirtyCode(), $match)) {
            $data->setCode($match[1]);
            return $this
                ->warehouseService
                ->executeCommandFIndCellByOnlyNumberWithColorCurrentYear($data);
        }

        if (preg_match('/^([0-9]{1,2}[%]{1}[0-9]{4,5})[*]$/', $data->getDirtyCode(), $match)) {
            $data->setCode($match[1]);
            return $this
                ->warehouseService
                ->executeCommandFIndCellByOnlyNumberWithColorAnotherYear($data);
        }

        if (preg_match('/^([0-9]{4,10})[@]$/', $data->getDirtyCode(), $match)) {
            $data->setCode($match[1]);
            return $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear($data);
        }

        if (preg_match('/^([0-9]{1,2}[%]{1}[0-9]{4,10})[@]$/', $data->getDirtyCode(), $match)) {
            $data->setCode($match[1]);
            return $this
                ->warehouseService
                ->executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear($data);
        }

        $this->warehouseService->unknownCommand($data);
//        throw new InvalidArgumentException("Unknown command {$data->getDirtyCode()}");
    }
}
