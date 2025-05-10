<?php

namespace App\Http\Controllers\Api;

use App\Models\Reader;
use App\Services\ApiService;
use App\Traits\ApiResponseTrait;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Post(
     *      path="/api/test",
     *      operationId="getTestData",
     *      tags={"Test"},
     *      security={{"XApiAuth": {}}},
     *      summary="Получить тестовые данные",
     *      description="Возвращает тестовые данные пользователя",
     *      @OA\Response(
     *          response=200,
     *          description="Успешный запрос",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="name", type="string", example="Administrator"),
     *                  @OA\Property(property="login", type="string", example="admin"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-10T13:19:55.609000Z"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-10T13:19:55.609000Z"),
     *                  @OA\Property(property="id", type="string", example="681f527b8ab7526eb80a1d12")
     *              ),
     *              @OA\Property(property="errors", type="object", example={}),
     *              @OA\Property(property="codError", type="integer", example=0),
     *              @OA\Property(property="textError", type="string", example=""),
     *              @OA\Property(property="message", type="string", example="Данные успешно получены")
     *          )
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Не авторизован",
     *           @OA\JsonContent(
     *               @OA\Property(property="success", type="boolean", example=false),
     *               @OA\Property(property="data", type="object", example={}),
     *               @OA\Property(property="errors", type="array", @OA\Items(type="string")),
     *               @OA\Property(property="codError", type="integer", example=1003),
     *               @OA\Property(property="textError", type="string", example="API_KEY_MISSING"),
     *               @OA\Property(property="message", type="string", example="Api key not found")
     *           )
     *       ),
     *      @OA\Response(
     *            response=403,
     *            description="Действие запрещено",
     *            @OA\JsonContent(
     *                @OA\Property(property="success", type="boolean", example=false),
     *                @OA\Property(property="data", type="object", example={}),
     *                @OA\Property(property="errors", type="array", @OA\Items(type="string")),
     *                @OA\Property(property="codError", type="integer", example=1008),
     *                @OA\Property(property="textError", type="string", example="FORBIDDEN"),
     *                @OA\Property(property="message", type="string", example="Action not allowed")
     *            )
     *        ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найдено",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="errors", type="array", @OA\Items(type="string")),
     *              @OA\Property(property="codError", type="integer", example=1007),
     *              @OA\Property(property="textError", type="string", example="ENTITY_NOT_FOUND"),
     *              @OA\Property(property="message", type="string", example="Запись не найдена")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ошибка сервера",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model"),
     *              @OA\Property(property="exception", type="string", example=""),
     *              @OA\Property(property="file", type="string", example="/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
     *              @OA\Property(property="line", type="integer", example=639),
     *              @OA\Property(
     *                  property="trace",
     *                  type="array",
     *                  @OA\Items(type="string")
     *              )
     *          )
     *      )
     * )
     */
    public function getTestData()
    {
        try {
            $data = Reader::where('login', 'admin')->firstOrFail();
            $response = $this->successResponse('Данные успешно получены', $data);
        } catch (\Exception $e) {
            $response = $this->errorResponse('Запись не найдена', ApiService::ENTITY_NOT_FOUND, [], 404);
        }
        return response()->json($response->data, $response->httpCode);
    }
}