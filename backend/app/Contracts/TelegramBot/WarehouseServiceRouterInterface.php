<?php

namespace App\Contracts\TelegramBot;

use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return array
     */
    public function router(Request $request): array;
}
