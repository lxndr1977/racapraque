<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $accessToken;
    private string $phoneNumberId;
    private string $version;
    private string $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->version = config('services.whatsapp.version', 'v21.0');
        $this->baseUrl = "https://graph.facebook.com/{$this->version}/{$this->phoneNumberId}/messages";
    }

    /**
     * Enviar mensagem de texto simples
     */
    public function sendTextMessage(string $to, string $message): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        return $this->sendMessage($payload);
    }

    /**
     * Enviar mensagem com template
     */
    public function sendTemplateMessage(string $to, string $templateName, array $parameters = [], string $languageCode = 'pt_BR'): array
    {
        $components = [];
        
        if (!empty($parameters)) {
            $components[] = [
                'type' => 'body',
                'parameters' => array_map(fn($param) => ['type' => 'text', 'text' => $param], $parameters)
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $languageCode
                ],
                'components' => $components
            ]
        ];

        return $this->sendMessage($payload);
    }

    /**
     * Enviar mensagem com mídia
     */
    public function sendMediaMessage(string $to, string $type, string $mediaUrl, string $caption = ''): array
    {
        $mediaData = [
            'link' => $mediaUrl
        ];

        if (!empty($caption) && in_array($type, ['image', 'video', 'document'])) {
            $mediaData['caption'] = $caption;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => $type,
            $type => $mediaData
        ];

        return $this->sendMessage($payload);
    }

    /**
     * Enviar mensagem com botões interativos
     */
    public function sendInteractiveMessage(string $to, string $bodyText, array $buttons, string $headerText = ''): array
    {
        $interactive = [
            'type' => 'button',
            'body' => [
                'text' => $bodyText
            ],
            'action' => [
                'buttons' => array_map(function($button, $index) {
                    return [
                        'type' => 'reply',
                        'reply' => [
                            'id' => $button['id'] ?? "btn_{$index}",
                            'title' => $button['title']
                        ]
                    ];
                }, $buttons, array_keys($buttons))
            ]
        ];

        if (!empty($headerText)) {
            $interactive['header'] = [
                'type' => 'text',
                'text' => $headerText
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'interactive',
            'interactive' => $interactive
        ];

        return $this->sendMessage($payload);
    }

    /**
     * Enviar lista interativa
     */
    public function sendListMessage(string $to, string $bodyText, array $sections, string $buttonText = 'Ver opções'): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->formatPhoneNumber($to),
            'type' => 'interactive',
            'interactive' => [
                'type' => 'list',
                'body' => [
                    'text' => $bodyText
                ],
                'action' => [
                    'button' => $buttonText,
                    'sections' => $sections
                ]
            ]
        ];

        return $this->sendMessage($payload);
    }

    /**
     * Método principal para envio de mensagens
     */
    private function sendMessage(array $payload): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, $payload);

            $result = $response->json();

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'to' => $payload['to'],
                    'message_id' => $result['messages'][0]['id'] ?? null
                ]);

                return [
                    'success' => true,
                    'message_id' => $result['messages'][0]['id'] ?? null,
                    'data' => $result
                ];
            }

            Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response' => $result,
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'error' => $result['error']['message'] ?? 'Erro desconhecido',
                'error_code' => $result['error']['code'] ?? null
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception', [
                'message' => $e->getMessage(),
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'error' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Formatar número de telefone
     */
    private function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove todos os caracteres não numéricos
        $phone = preg_replace('/\D/', '', $phoneNumber);
        
        // Se não tem código do país, adiciona o código do Brasil (55)
        if (strlen($phone) === 11 && substr($phone, 0, 1) !== '55') {
            $phone = '55' . $phone;
        }
        
        return $phone;
    }

    /**
     * Verificar status de uma mensagem
     */
    public function getMessageStatus(string $messageId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
            ])->get("https://graph.facebook.com/{$this->version}/{$messageId}");

            return [
                'success' => $response->successful(),
                'data' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function sendTemplateTest($phone)
    {
         $testPhoneNumber = $phone;

        
        $result = $this->sendTemplateMessage(
            $testPhoneNumber,
            'hello_world',
            [],
            'en_US'
        );

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? 'Template enviado com sucesso!' : 'Falha ao enviar template',
            'phone_number' => $testPhoneNumber,
            'template_used' => 'hello_world',
            'language' => 'en_US',
            'result' => $result,
            'note' => 'Este é o template padrão aprovado. Após receber esta mensagem, você pode enviar mensagens de texto livre por 24h.'
        ]);
    }
}