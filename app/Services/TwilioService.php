<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }

    public function sendWhatsApp($to, $message)
    {
        try {
            // Log para debug
            Log::info('Enviando WhatsApp', [
                'to' => $to,
                'from' => $this->from,
                'message' => $message
            ]);

            $response = $this->client->messages->create(
                'whatsapp:' . $to, // Para WhatsApp - formato obrigatório
                [
                    'from' => 'whatsapp:' . $this->from, // From WhatsApp - formato obrigatório
                    'body' => $message
                ]
            );

            Log::info('WhatsApp enviado com sucesso', [
                'sid' => $response->sid,
                'status' => $response->status
            ]);

            return [
                'success' => true,
                'sid' => $response->sid,
                'status' => $response->status,
                'message' => 'Mensagem WhatsApp enviada com sucesso!'
            ];

        } catch (Exception $e) {
            Log::error('Erro ao enviar WhatsApp', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function sendSms($to, $message)
    {
        try {
            $response = $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );

            return [
                'success' => true,
                'sid' => $response->sid,
                'status' => $response->status,
                'message' => 'SMS enviado com sucesso!'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getMessageStatus($messageSid)
    {
        try {
            $message = $this->client->messages($messageSid)->fetch();
            
            return [
                'success' => true,
                'status' => $message->status,
                'error_code' => $message->errorCode,
                'error_message' => $message->errorMessage,
                'date_sent' => $message->dateSent,
                'date_updated' => $message->dateUpdated
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}