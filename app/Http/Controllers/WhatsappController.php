<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;

class WhatsappController extends Controller
{
    public function send(TwilioService $twilio)
    {
        // Certifique-se de que o número está no formato correto
        $phoneNumber = '+555181388656';
        $message = 'OTestegração está funcionando perfeitamente!';

        $result = $twilio->sendWhatsApp($phoneNumber, $message);
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'sid' => $result['sid'],
                'status' => $result['status']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Falha ao enviar WhatsApp',
                'details' => $result['error'],
                'code' => $result['code'] ?? null
            ], 500);
        }
    }

    public function sendCustom(Request $request, TwilioService $twilio)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:1600'
        ]);

        $result = $twilio->sendWhatsApp($request->phone, $request->message);
        
        return response()->json($result);
    }

    public function checkStatus(Request $request, TwilioService $twilio)
    {
        $request->validate([
            'message_sid' => 'required|string'
        ]);

        $result = $twilio->getMessageStatus($request->message_sid);
        
        return response()->json($result);
    }

    public function testSms(TwilioService $twilio)
    {
        $phoneNumber = '+5551981388656';
        $message = 'Teste SMS via Twilio no Laravel 12!';

        $result = $twilio->sendSms($phoneNumber, $message);
        
        return response()->json($result);
    }
}