<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;

class ApiService
{
    /**
     * Авторизация невозможна, проверьте данные учётной записи.
     */
    public const INVALID_CREDENTIALS = 1001;

    /**
     * Данный ключ не активен. Попробуйте пройти процесс авторизации заново.
     */
    public const REFRESH_TOKEN_NOT_VALID = 1002;

    /**
     * Отсутствует API ключ в заголовке.
     */
    public const API_KEY_MISSING = 1003;

    /**
     * Неверный формат API ключа.
     */
    public const API_KEY_INVALID_FORMAT = 1004;

    /**
     * Истекло время действия API ключа.
     */
    public const API_KEY_EXPIRED = 1005;

    /**
     * Неверный  API ключ.
     */
    public const API_KEY_NOT_VALID = 1006;

    /**
     * Запрашиваемая сущность не найдена.
     */
    public const ENTITY_NOT_FOUND = 1007;

    /**
     * Действие запрещено.
     */
    public const FORBIDDEN = 1008;

    /**
     * Ошибка валидации данных
     */
    public const VALIDATION_ERROR = 1009;

    /**
     * Сбой в отправки оповещения
     */
    public const FAILED_DEPENDENCY = 1010;

    public static function textError(int $codError): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();

        foreach ($constants as $name => $value) {
            if ($value === $codError) {
                return $name;
            }
        }

        return 'UNKNOWN_ERROR';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getSwaggerApiDocs(): array
    {
        $filePath = storage_path('api-docs/api-docs.json');

        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new \Exception("Файл api-docs.json swagger API не найден по пути: $filePath");
        }

        $jsonContent = file_get_contents($filePath);

        $dataObject = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Не удалось декодировать JSON из api-docs.json swagger API : ' . json_last_error_msg());
        }

        return $dataObject;
    }

    /**
     * @param string $route
     * @param string $method
     * @return array
     * @throws \Exception
     */
    public function getSwaggerMethodApiDocsResponsesSchema(string $route, string $method, int $code): array
    {
        $swaggerApiDocs = $this->getSwaggerApiDocs();

        if (
            !isset($swaggerApiDocs['paths'][$route][$method]['responses'][$code]['content']['application/json']['schema'])
        ) {
            throw new \Exception("В Swagger API отсутствуют ответы для маршрута: $route и метода: $method");
        }

        return $swaggerApiDocs['paths'][$route][$method]['responses'][$code]['content']['application/json']['schema']['properties'];
    }

    public function getArrayKeys(array $array): array
    {
        $structure = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ($key === 'properties') {
                    continue;
                }

                $nestedStructure = $this->getArrayKeys($value);
                $structure[$key] = $nestedStructure ?: $key;
            } else {
                $structure[$key] = '';
            }
        }

        return $structure;
    }
}
