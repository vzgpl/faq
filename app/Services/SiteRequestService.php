<?php

namespace App\Services;

use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Response;
use App\Mail\ApplicationReceived;
use Illuminate\Support\Facades\Mail;
class SiteRequestService
{
    use ApiResponseTrait;

    public function sendEmail(array $data)
    {
        $applicationData = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'ip' => $data['ip'],
            'received_at' => $data['received_at'],
        ];

        try {
            $toEmail = 'deerstalker@inbox.ru';
            Mail::to($toEmail)->send(new ApplicationReceived($applicationData));
            return $this->successResponse('Заявка успешно отправлена', $applicationData);
        } catch (\Exception $e) {
            return $this->errorResponse('Сбой в отправки оповещения', ApiService::FAILED_DEPENDENCY, [], 424);
        }
    }
}
