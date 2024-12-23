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
                $this->message .= "{$key} : {$value}" . PHP_EOL;
            }
            if ($rowCount > 2) {
                $this->message .= "______________________" . PHP_EOL;
            }
        }

        return $this->message;
    }
}
