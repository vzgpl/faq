<?php

namespace App\Http\Controllers\Api;

use App\Models\Reader;
use App\Services\ApiService;
use App\Services\SiteRequestService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteRequestController extends \App\Http\Controllers\Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Post(
     *      path="/api/send-request",
     *      operationId="sendSiteRequest",
     *      tags={"Site Requests"},
     *      summary="Отправка заявки с сайта",
     *      description="Принимает имя и телефон от пользователя и отправляет заявку на обработку",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Данные заявки",
     *          @OA\JsonContent(
     *              required={"name", "phone"},
     *              @OA\Property(property="name", type="string", example="Тест Тестов", description="Имя клиента"),
     *              @OA\Property(property="phone", type="string", example="+7301570000", description="Телефон")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Заявка успешно принята",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="name", type="string", example="Тест Тестов"),
     *                  @OA\Property(property="phone", type="string", example="+7301570000"),
     *                  @OA\Property(property="ip", type="string", example="127.0.0.1"),
     *                  @OA\Property(property="received_at", type="string", format="date-time", example="2025-05-15T14:30:00")
     *              ),
     *              @OA\Property(property="errors", type="object", example={}),
     *              @OA\Property(property="codError", type="integer", example=0),
     *              @OA\Property(property="textError", type="string", example=""),
     *              @OA\Property(property="message", type="string", example="Заявка успешно отправлена")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Ошибка валидации",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      type="array",
     *                      @OA\Items(type="string", example="Поле имя обязательно для заполнения")
     *                  ),
     *                  @OA\Property(
     *                      property="phone",
     *                      type="array",
     *                      @OA\Items(type="string", example="Поле телефон обязательно для заполнения")
     *                  )
     *              ),
     *              @OA\Property(property="codError", type="integer", example=1009),
     *              @OA\Property(property="textError", type="string", example="VALIDATION_ERROR"),
     *              @OA\Property(property="message", type="string", example="Ошибка валидации данных")
     *          )
     *      ),
     *      @OA\Response(
     *           response=424,
     *           description="Сбой в отправки оповещения",
     *           @OA\JsonContent(
     *               @OA\Property(property="success", type="boolean", example=false),
     *               @OA\Property(property="data", type="object", example={}),
     *               @OA\Property(
     *                   property="errors",
     *                   type="object",
     *               ),
     *               @OA\Property(property="codError", type="integer", example=1010),
     *               @OA\Property(property="textError", type="string", example="FAILED_DEPENDENCY"),
     *               @OA\Property(property="message", type="string", example="Сбой в отправки оповещения")
     *           )
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Ошибка сервера",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="errors", type="object", example={"server": "Internal server error"}),
     *              @OA\Property(property="codError", type="integer", example=1000),
     *              @OA\Property(property="textError", type="string", example="SERVER_ERROR"),
     *              @OA\Property(property="message", type="string", example="Произошла ошибка при обработке заявки")
     *          )
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function sendRequest(Request $request,SiteRequestService $requestService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'name.required' => 'Поле имя обязательно для заполнения',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',
            'phone.required' => 'Поле телефон обязательно для заполнения',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не должен превышать 20 символов',
        ]);

        if ($validator->fails()) {
            $response = $this->errorResponse('', ApiService::VALIDATION_ERROR, $validator->errors()->toArray(), 422);
            return response()->json($response->data, $response->httpCode);
        }

        $validDate = $validator->validate();
        $validDate = [
            'name' => $validDate['name'],
            'phone' => $validDate['phone'],
            'ip' => $request->ip(),
            'received_at' => now()->format('Y-m-d H:i:s'),
        ];

        $response = $requestService->sendEmail($validDate);

        return response()->json($response->data, $response->httpCode);
    }
}