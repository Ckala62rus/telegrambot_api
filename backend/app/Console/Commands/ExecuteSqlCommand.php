<?php

namespace App\Console\Commands;

use App\Contracts\TelegramBot\WarehouseServiceInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ExecuteSqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ExecuteSqlCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        /** @var WarehouseServiceInterface $wh */
        $wh = app(WarehouseServiceInterface::class);

        // поиск по номеру ( НЕ РАБОТАЕТ )
//        $wh->executeCommandFindCellByOnlyNumberAnotherYear('24%15278');

        // поиск по номеру
//        $wh->executeCommandFindCellByOnlyNumberCurrentYear('15278');

        // поиск по номеру с цветом за текущий год
//        $wh->executeCommandFIndCellByOnlyNumberWithColorCurrentYear('15278');

        // поиск по номеру с цветом за любой год
//        $wh->executeCommandFIndCellByOnlyNumberWithColorAnotherYear('24%15278');

        // поиск по номеру с цветом и пользователем за текущий год
//        $wh->executeCommandFindCellByOnlyNumberWithColorAndUserCurrentYear('15278');

        // поиск по номеру с цветом и пользователем за текущий год
        $wh->executeCommandFindCellByOnlyNumberWithColorAndUserAnotherYear('24%15278');
        return CommandAlias::SUCCESS;
    }
}
