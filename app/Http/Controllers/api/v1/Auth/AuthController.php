<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Contracts\Auth\IAuthService;
use App\DTO\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SystemLoginRequest;
use App\Http\Resources\Auth\ApiLoginResource;
use App\Http\Resources\Auth\ApiRegisterResource;
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
        $authDTO = $this->authService->loginWith('api', $systemLoginRequest->validated());

        $token = $authDTO->getToken();
        $user = $authDTO->getUser();
        $message = $authDTO->getMessage();

        if (empty($token) || empty($user))
            return $this->getHttpResponse(new ResponseDTO(false, $message, null, 401));

        $data = [
            'token' => $token,
            'user' => $user
        ];
        $response = new ResponseDTO(
            true,
            $message,
            $this->toResource(ApiLoginResource::class, $data)
        );
        return $this->getHttpResponse($response);
    }

    #[Endpoint('Register')]
    public function register(RegisterRequest $registerRequest)
    {
        $modelResponseDTO = $this->authService->register($registerRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, ApiRegisterResource::class);
    }

    #[Endpoint('Logout')]
    public function logout(LogoutRequest $logoutRequest)
    {
        $modelResponseDTO = $this->authService->logout($logoutRequest->user(), $logoutRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO);
    }
}
