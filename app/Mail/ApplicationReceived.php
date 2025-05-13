<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationData;

    public function __construct($applicationData)
    {
        $this->applicationData = $applicationData;
    }

    public function build()
    {
        return $this->subject('Новая заявка с сайта')
            ->view('emails.application')
            ->with([
                'name' => $this->applicationData['name'],
                'phone' => $this->applicationData['phone'],
                'received_at' => $this->applicationData['received_at'],
                'ip' => $this->applicationData['ip'],
            ]);
    }
}