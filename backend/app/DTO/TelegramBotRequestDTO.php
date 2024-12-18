<?php

namespace App\DTO;

class TelegramBotRequestDTO
{
    /**
     * Input code from telegram
     * @var string
     */
    private string $dirtyCode;

    /**
     * Here code after processing
     * @var string
     */
    private string $code;

    /**
     * Telegram user id for send answer about part
     * @var string
     */
    private string $telegramUserId;

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->dirtyCode = $request['code_for_looking'];
        $this->telegramUserId = $request['telegram_user_id'];
    }

    /**
     * @return string
     */
    public function getDirtyCode(): string
    {
        return $this->dirtyCode;
    }

    /**
     * @return string
     */
    public function getTelegramUserId(): string
    {
        return $this->telegramUserId;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
