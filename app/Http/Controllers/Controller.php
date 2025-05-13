<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="PBX Swagger API documentation example",
 *      version="3.0.0",
 *      description="API",
 *      @OA\Contact(
 *          email="deerstalker@inbox.ru"
 *      ),
 *
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="XApiAuth",
 *   type="apiKey",
 *   name="X-API-KEY",
 *   in="header"
 * )
 */

abstract class Controller
{

}
