<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Contracts\Auth\IAuthService;
use App\DTO\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SystemLoginRequest;
use Dedoc\Scramble\Attributes\Endpoint;

class AuthController extends Controller
{
    protected IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Endpoint('Login')]
    public function login(SystemLoginRequest $systemLoginRequest)
    {
        $login_data = $systemLoginRequest->validated();
        $login_data['type'] = 'system';

        $authDTO = $this->authService->login($login_data);

        $token = $authDTO->getToken();
        $user = $authDTO->getUser();
        $message = $authDTO->getMessage();

        if (empty($token) || empty($user))
            return $this->getHttpResponse(new ResponseDTO(false, $message, null, 401));

        $data = [
            'token' => $token,
            'user' => $user
        ];
        $response = new ResponseDTO(true, $message, $data);
        return $this->getHttpResponse($response);
    }

    #[Endpoint('Register')]
    public function register(RegisterRequest $registerRequest)
    {
        $authDTO = $this->authService->register($registerRequest->validated());

        $data = [
            'token' => $authDTO->getToken(),
            'user' => $authDTO->getUser()
        ];
        return $this->getHttpResponse(new ResponseDTO(
            (bool)$data['user'],
            $authDTO->getMessage(),
            $data['user'] ? $data : null,
            $data['user'] ? 201 : 500
        ));
    }

    #[Endpoint('Logout')]
    public function logout(LogoutRequest $logoutRequest)
    {
        $authDTO = $this->authService->logout($logoutRequest->user(), $logoutRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            !$authDTO->getUser(),
            $authDTO->getMessage(),
            null,
        ));
    }
}
