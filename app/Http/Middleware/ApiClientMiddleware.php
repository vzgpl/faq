<?php

namespace App\Http\Middleware;

use App\Services\ApiService;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiClientMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (empty($apiKey)){
            $response = $this->errorResponse('Api key not found',
                ApiService::API_KEY_MISSING, [], 401);
            return response()->json($response->data, $response->httpCode);
        }

        if (!$this->isValidApiKey($apiKey) ) {
            $response = $this->errorResponse('Invalid api key',
                ApiService::API_KEY_NOT_VALID, [], 401);
            return response()->json($response->data, $response->httpCode);
        }

        return $next($request);
    }

    /**
     * todo сервисная логика
     * Проверяет валидность API-ключа
     *
     * @param string|null $apiKey
     * @return bool
     */
    protected function isValidApiKey(?string $apiKey): bool
    {
        if (empty($apiKey)) {
            return false;
        }

        $validKeys = explode(',', env('API_KEYS', '1'));

        return in_array($apiKey, $validKeys);
    }
}