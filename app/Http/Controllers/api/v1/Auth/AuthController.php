<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Contracts\Auth\IAuthService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SystemLoginRequest;

class AuthController extends Controller
{
    protected IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(SystemLoginRequest $systemLoginRequest)
    {
        $login_data = $systemLoginRequest->validated();
        $login_data['type'] = 'system';

        $system_login_dto = $this->authService->login($login_data);

        $token = $system_login_dto->getToken();
        $user = $system_login_dto->getUser();
        $message = $system_login_dto->getMessage();

        if (empty($token) || empty($user))
            return $this->getHttpResponse(new ResponseDTO(false, $message, null, 401));

        $data = [
            'token' => $token,
            'user' => $user
        ];
        $response = new ResponseDTO(true, $message, $data);
        return $this->getHttpResponse($response);
    }
}
