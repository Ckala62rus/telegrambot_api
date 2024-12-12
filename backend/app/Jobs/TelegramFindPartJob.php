<?php

namespace App\Jobs;

use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TelegramFindPartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private array $request,
        private WarehouseServiceRouterInterface $warehouseServiceRouter,
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->warehouseServiceRouter->router($this->request);
    }
}
