<?php

namespace App\Http\Controllers;

use App\Contracts\TelegramBot\WarehouseServiceRouterInterface;
use App\Jobs\TelegramFindPartJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TelegramController extends BaseController
{
    /**
     * @param WarehouseServiceRouterInterface $serviceRouter
     */
    public function __construct(
        private WarehouseServiceRouterInterface $serviceRouter,
    ) {
    }

    /**
     * Find party by number
     * @param Request $request
     * @return JsonResponse
     */
    public function findPartyByNumber(Request $request): JsonResponse
    {
        TelegramFindPartJob::dispatch($request->all(), $this->serviceRouter);

        return $this->response(
            data: [],
            message: "OK",
            statusCode: Response::HTTP_OK,
        );
    }
}


//input params = [
//    telegram_user_id => 135792468, (int)
//    code_for_looking => '12345' (string)
//]
