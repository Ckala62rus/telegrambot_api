<?php

namespace Tests\Feature\Warehouse;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;
use Mockery;
use Tests\TestCase;

class WarehouseServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }

    public function validUsersData(): array
    {
        return [
            [
                [
                    'code_for_looking' => '15525',
                    'process_method' => 'executeCommandFindCellByOnlyNumberCurrentYear'
                ], // input data
                ['email', 'password'] // result data
            ],
            [
                [
                    'code_for_looking' => '24%15525',
                    'process_method' => 'executeCommandFindCellByOnlyNumberAnotherYear'
                ],
                ['email', 'password']
            ],
            [
                [
                    'code_for_looking' => '15525*',
                    'process_method' => 'executeCommandFIndCellByOnlyNumberWithColorCurrentYear'
                ],
                ['email', 'password']
            ],
            [
                [
                    'code_for_looking' => '24%15525*',
                    'process_method' => 'executeCommandFIndCellByOnlyNumberWithColorAnotherYear'
                ],
                ['email', 'password']
            ],
            [
                [
                    'code_for_looking' => '15525@',
                    'process_method' => 'executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear'
                ],
                ['email', 'password']
            ],
            [
                [
                    'code_for_looking' => '24%15525@',
                    'process_method' => 'executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear'
                ],
                ['email', 'password']
            ],
        ];
    }

    /**
     * clear && vendor/bin/phpunit --filter=WarehouseServiceTest
     *
     * @dataProvider validUsersData
     * @param $validData
     * @param $result
     * @return void
     */
    public function testProcessCommandForFindPart($validData, $result): void
    {
        // arrange
        $config = Mockery::mock(WarehouseServiceInterface::class)->makePartial();
        $config
            ->shouldReceive($validData['process_method'])
            ->andReturn([])
            ->once();

        $this
            ->app
            ->instance(WarehouseServiceInterface::class, $config);

        /** @var WarehouseServiceRouterInterface $whs */
        $whs = $this
            ->app
            ->make(
                WarehouseServiceRouterInterface::class
            );

        // act
        $result = $whs->router([
            'telegram_user_id' => '803431360',
            'code_for_looking' => $validData['code_for_looking'],
        ]);

//        dd($result);
        // assert
        $this->assertTrue(true);
    }
}
