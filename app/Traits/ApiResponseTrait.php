<?php

namespace App\Traits;

use App\Services\ApiService;
use stdClass;

trait ApiResponseTrait
{
    /**
     * Формирование объекта ответа об ошибке
     *
     * @param string $message
     * @param int $codError Код ошибки приложения
     * @param mixed $errors Дополнительные ошибки
     * @param int $httpCode HTTP-код ответа
     * @return object
     */
    public static function errorResponse(string $message, int $codError, $errors = null, int $httpCode = 403): object
    {
        return (object)[
            'data' => [
                'success' => false,
                'data' => new stdClass(),
                'errors' => $errors,
                'codError' => $codError,
                'textError' => ApiService::textError($codError),
                'message' => $message,
            ],
            'httpCode' => $httpCode
        ];
    }

    /**
     * Формирование успешного объекта ответа
     *
     * @param string $message
     * @param mixed $data Данные ответа
     * @return object
     */
    public static function successResponse(string $message, $data = null): object
    {
        return (object)[
            'data' =>[
                'success' => true,
                'data' => $data,
                'errors' => new stdClass(),
                'codError' => 0,
                'textError' => '',
                'message' => $message,
            ],
            'httpCode' => 200
        ];
    }
}