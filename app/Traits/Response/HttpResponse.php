<?php

namespace App\Traits\Response;

use App\DTO\Response\ResponseDTO;

trait HttpResponse
{
    public function getHttpResponse(ResponseDTO $responseDTO)
    {
        $res = [
            'success' => $responseDTO->isSuccess(),
            'message' => $responseDTO->getMessage()
        ];

        if (!empty($responseDTO->getData()))
            $res['data'] = $responseDTO->getData();

        return response()->json($res, $responseDTO->getStatusCode());
    }
}
