<?php

namespace App\Contracts\TelegramBot;

interface TelegramNotificationServiceInterface
{
    public function sendMessageToTelegram(string $message, string $id_user): bool|string;
}
