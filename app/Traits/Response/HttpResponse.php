<?php

namespace App\Traits\Response;

use App\DTO\ResponseDTO;

trait HttpResponse
{
    public function getHttpResponse(ResponseDTO $responseService)
    {
        $res = [
            'success' => $responseService->isSuccess(),
            'message' => $responseService->getMessage()
        ];

        if (!empty($responseService->getData()))
            $res['data'] = $responseService->getData();

        return response()->json($res, $responseService->getStatusCode());
    }
}
