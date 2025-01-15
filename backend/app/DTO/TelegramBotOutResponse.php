<?php

namespace App\DTO;

class TelegramBotOutResponse
{
    /**
     * @var array|string[]
     */
    private array $fields = [
        'BATCH',
        'WMSLOCATION',
        'NAMEALIAS',
        'LICENSE',
    ];

    /**
     * @var array
     */
    private array $translateField = [
        "CONFIGID" => "Конфиг: ",
        "COLORID" => "Цвет: ",
        "WMSLOCATION" => "Яч: ",
        "LICENSE" => "НЗ: ",
        "USERNAME" => "ФИО: ",
    ];

    /**
     * @var array
     */
    private array $outData = [];

    /**
     * @var string
     */
    private string $message = '';

    /**
     * @param array $data
     * @param array $someField
     */
    public function __construct(array $data, array $someField = [])
    {
        $rows = $data['data'];

//        $msg .= $item->BATCH . PHP_EOL;
//        $msg .= $item->NAMEALIAS . PHP_EOL;
//        $msg .= "Конфиг: " . $item->CONFIGID . PHP_EOL;
//        $msg .= "Цвет: " . $item->COLORID . PHP_EOL;
//        $msg .= "Яч: " . $item->WMSLOCATION . PHP_EOL;
//        $msg .= "НЗ: " . $item->LICENSE . PHP_EOL;
//        $msg .= PHP_EOL;

        $this->fields = array_merge($this->fields, $someField);

        foreach ($rows as $key => $item) {
            foreach ($this->fields as $field) {
                if (property_exists($item, $field)) {
                    $this->outData[$key][$field] = $item->$field;
                }
            }
        }
    }

    /**
     * Get completed message
     * @return string
     */
    public function getCellByOnlyNumberCurrentYear(): string
    {
        $rowCount = count($this->outData);

        foreach ($this->outData as $item) {
            foreach ($item as $key => $value) {
                if (array_key_exists($key, $this->translateField)) {
                    $this->message .= "{$this->translateField[$key]} {$value}" . PHP_EOL;
                } else {
                    $this->message .= "{$value}" . PHP_EOL;
                }
            }
            if ($rowCount > 2) {
                $this->message .= "______________________" . PHP_EOL;
            }
        }

        return $this->message;
    }
}
