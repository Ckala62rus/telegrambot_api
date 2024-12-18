<?php

namespace App\Contracts\TelegramBot;

interface WarehouseServiceRouterInterface
{
    /**
     * Perform and execute command from telegram bot.
     *
     * input params =
     *  [
     *      telegram_user_id => 135792468, (int)
     *      code_for_looking => '12345' (string)
     *  ]
     *
     * @param array $data
     * @return bool
     */
    public function router(array $data): bool;
}
