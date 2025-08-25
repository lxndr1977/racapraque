<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhatsAppApiController extends Controller
{
    public function __construct(
        private WhatsAppService $whatsAppService
    ) {}

    /**
     * Enviar mensagem de texto
     */
    public function sendTextMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|string',
            'message' => 'required|string|max:4096'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->whatsAppService->sendTextMessage(
            $request->to,
            $request->message
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Enviar mensagem com template
     */
    public function sendTemplateMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|string',
            'template_name' => 'required|string',
            'parameters' => 'array',
            'language_code' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->whatsAppService->sendTemplateMessage(
            $request->to,
            $request->template_name,
            $request->parameters ?? [],
            $request->language_code ?? 'pt_BR'
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Enviar mídia
     */
    public function sendMediaMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|string',
            'type' => 'required|in:image,video,audio,document',
            'media_url' => 'required|url',
            'caption' => 'string|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->whatsAppService->sendMediaMessage(
            $request->to,
            $request->type,
            $request->media_url,
            $request->caption ?? ''
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Enviar mensagem com botões
     */
    public function sendInteractiveMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|string',
            'body_text' => 'required|string',
            'buttons' => 'required|array|min:1|max:3',
            'buttons.*.title' => 'required|string|max:20',
            'buttons.*.id' => 'string',
            'header_text' => 'string|max:60'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->whatsAppService->sendInteractiveMessage(
            $request->to,
            $request->body_text,
            $request->buttons,
            $request->header_text ?? ''
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Webhook para receber mensagens (verificação)
     */
    public function webhook(Request $request): JsonResponse|string
    {
        // Verificação do webhook
        if ($request->has('hub_mode') && $request->has('hub_verify_token')) {
            $mode = $request->input('hub_mode');
            $token = $request->input('hub_verify_token');
            $challenge = $request->input('hub_challenge');

            if ($mode === 'subscribe' && $token === config('services.whatsapp.webhook_verify_token')) {
                return $challenge;
            }

            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Processar mensagens recebidas
        $body = $request->all();
        
        if (isset($body['entry'])) {
            foreach ($body['entry'] as $entry) {
                if (isset($entry['changes'])) {
                    foreach ($entry['changes'] as $change) {
                        if ($change['field'] === 'messages') {
                            $this->processIncomingMessage($change['value']);
                        }
                    }
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Processar mensagens recebidas
     */
    private function processIncomingMessage(array $value): void
    {
        if (!isset($value['messages'])) {
            return;
        }

        foreach ($value['messages'] as $message) {
            // Aqui você pode implementar sua lógica para processar mensagens recebidas
            // Por exemplo, salvar no banco de dados, responder automaticamente, etc.
            
         
        }
    }

    /**
     * Verificar status de mensagem
     */
    public function getMessageStatus(Request $request, string $messageId): JsonResponse
    {
        $result = $this->whatsAppService->getMessageStatus($messageId);
        
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Rota de teste - envia mensagem automaticamente (SEQUÊNCIA CORRETA)
     */
    public function sendTestMessage(Request $request): JsonResponse
    {
        // Número de teste - você pode configurar no .env ou passar como parâmetro
        $testPhoneNumber = $request->get('phone') ?? config('services.whatsapp.test_phone_number') ?? '5551981388656';
        
        $testResults = [];
        
        try {
            // Primeiro, vamos validar as configurações
            $configCheck = $this->validateTestConfiguration();
            if (!$configCheck['valid']) {
                return response()->json([
                    'success' => false,
                    'error' => 'Configuração inválida',
                    'details' => $configCheck,
                    'phone_number' => $testPhoneNumber,
                    'timestamp' => now()->toISOString()
                ], 400);
            }

            // TESTE 1: PRIMEIRO enviar template aprovado (obrigatório para iniciar conversa)
            $templateResult = $this->whatsAppService->sendTemplateMessage(
                $testPhoneNumber,
                'hello_world',
                [],
                'en_US'
            );
            $testResults['template_message'] = $templateResult;

            // Aguardar 3 segundos entre mensagens
            sleep(3);

            // TESTE 2: Mensagem de texto (só funciona após template ou resposta do usuário)
            if ($templateResult['success']) {
                $textResult = $this->whatsAppService->sendTextMessage(
                    $testPhoneNumber,
                    "🚀 *Teste de Mensagem Livre*\n\n" .
                    "✅ Agora posso enviar mensagens de texto!\n" .
                    "📅 Enviado em: " . now()->format('d/m/Y H:i:s') . "\n\n" .
                    "Esta mensagem só funciona após o template ser enviado.\n\n" .
                    "📱 Phone Number ID: " . config('services.whatsapp.phone_number_id')
                );
                $testResults['text_message'] = $textResult;

                // Aguardar mais 3 segundos
                sleep(3);

                // TESTE 3: Mensagem com botões (apenas se text foi enviado com sucesso)
                if ($textResult['success']) {
                    $buttonsResult = $this->whatsAppService->sendInteractiveMessage(
                        $testPhoneNumber,
                        "🔧 *Teste de Botões Interativos*\n\nEscolha uma das opções abaixo:",
                        [
                            ['id' => 'test_btn_1', 'title' => '✅ Funcionou!'],
                            ['id' => 'test_btn_2', 'title' => '🔄 Testar novamente'],
                            ['id' => 'test_btn_3', 'title' => '📞 Suporte']
                        ],
                        "🤖 Sistema de Teste"
                    );
                    $testResults['interactive_message'] = $buttonsResult;
                }
            }

            // TESTE 4: Enviar uma imagem de exemplo (opcional)
            if ($request->get('with_media') === 'true' && isset($textResult) && $textResult['success']) {
                sleep(3);
                $mediaResult = $this->whatsAppService->sendMediaMessage(
                    $testPhoneNumber,
                    'image',
                    'https://via.placeholder.com/800x600/4CAF50/white?text=WhatsApp+API+Test',
                    '🖼️ Imagem de teste da integração WhatsApp API'
                );
                $testResults['media_message'] = $mediaResult;
            }

            // Resumo dos resultados
            $successCount = collect($testResults)->where('success', true)->count();
            $totalTests = count($testResults);

            return response()->json([
                'success' => true,
                'message' => "Teste automático concluído! {$successCount}/{$totalTests} mensagens enviadas com sucesso.",
                'phone_number' => $testPhoneNumber,
                'timestamp' => now()->toISOString(),
                'configuration' => $configCheck,
                'test_sequence' => [
                    '1. Template hello_world (obrigatório primeiro)',
                    '2. Mensagem de texto livre',
                    '3. Botões interativos',
                    '4. Mídia (se solicitado)'
                ],
                'results' => $testResults,
                'summary' => [
                    'total_tests' => $totalTests,
                    'successful' => $successCount,
                    'failed' => $totalTests - $successCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro durante o teste automático: ' . $e->getMessage(),
                'phone_number' => $testPhoneNumber,
                'timestamp' => now()->toISOString(),
                'results' => $testResults
            ], 500);
        }
    }

    /**
     * Validar configuração de teste
     */
    private function validateTestConfiguration(): array
    {
        $config = [
            'access_token' => config('services.whatsapp.access_token'),
            'phone_number_id' => config('services.whatsapp.phone_number_id'),
            'version' => config('services.whatsapp.version'),
        ];

        $validation = [
            'valid' => true,
            'config' => $config,
            'checks' => [],
            'warnings' => [],
            'suggestions' => []
        ];

        // Verificar se as configurações estão presentes
        if (empty($config['access_token'])) {
            $validation['valid'] = false;
            $validation['checks']['access_token'] = '❌ Token de acesso não configurado';
            $validation['suggestions'][] = 'Configure WHATSAPP_ACCESS_TOKEN no arquivo .env';
        } else {
            $validation['checks']['access_token'] = '✅ Token de acesso configurado';
            
            // Verificar se o token parece ser válido (formato básico)
            if (!str_starts_with($config['access_token'], 'EAA') || strlen($config['access_token']) < 100) {
                $validation['warnings'][] = '⚠️ O token de acesso pode estar incorreto (formato inesperado)';
            }
        }

        if (empty($config['phone_number_id'])) {
            $validation['valid'] = false;
            $validation['checks']['phone_number_id'] = '❌ Phone Number ID não configurado';
            $validation['suggestions'][] = 'Configure WHATSAPP_PHONE_NUMBER_ID no arquivo .env';
        } else {
            $validation['checks']['phone_number_id'] = '✅ Phone Number ID configurado: ' . $config['phone_number_id'];
            
            // Verificar se é um ID numérico (não um número de telefone)
            if (!is_numeric($config['phone_number_id']) || strlen($config['phone_number_id']) < 10) {
                $validation['valid'] = false;
                $validation['warnings'][] = '❌ Phone Number ID deve ser numérico (ex: 756769430852057)';
                $validation['suggestions'][] = 'Use o "Identificação do número de telefone" do Meta for Developers, não o número de telefone';
            }
        }

        // Verificar se o número de telefone de teste está no formato correto
        $testPhone = config('services.whatsapp.test_phone_number');
        if (!empty($testPhone)) {
            $validation['checks']['test_phone'] = '✅ Número de teste configurado: ' . $testPhone;
            
            if (!preg_match('/^55\d{10,11}$/', preg_replace('/\D/', '', $testPhone))) {
                $validation['warnings'][] = '⚠️ Número de teste pode estar em formato incorreto (use formato: 5551981388656)';
            }
        } else {
            $validation['warnings'][] = '⚠️ WHATSAPP_TEST_PHONE_NUMBER não configurado (opcional)';
        }

        return $validation;
    }

    /**
     * Página de teste com interface amigável
     */
    public function testPage(): \Illuminate\View\View
    {
        return view('whatsapp.test');
    }

    
    /**
     * Gerar recomendações baseadas no diagnóstico
     */
    private function generateRecommendations(array $diagnostics): array
    {
        $recommendations = [];

        if (!$diagnostics['access_token_valid']) {
            $recommendations[] = [
                'priority' => 'high',
                'title' => 'Access Token Inválido',
                'description' => 'Seu access token não é válido ou expirou.',
                'actions' => [
                    '1. Acesse Meta for Developers (developers.facebook.com)',
                    '2. Vá para sua aplicação WhatsApp',
                    '3. Em "API Setup", gere um novo token temporário',
                    '4. Para produção, configure um token permanente'
                ]
            ];
        }

        if (!$diagnostics['phone_number_exists']) {
            $recommendations[] = [
                'priority' => 'high',
                'title' => 'Phone Number ID Incorreto',
                'description' => 'O Phone Number ID configurado não existe ou você não tem permissão.',
                'actions' => [
                    '1. Verifique se você está usando o Phone Number ID (não o número)',
                    '2. No Meta for Developers, vá em "API Setup"',
                    '3. Copie o "Phone number ID" (formato: 1234567890123456)',
                    '4. Cole no WHATSAPP_PHONE_NUMBER_ID do seu .env'
                ]
            ];
        }

        if (isset($diagnostics['available_numbers']) && empty($diagnostics['available_numbers'])) {
            $recommendations[] = [
                'priority' => 'medium',
                'title' => 'Nenhum Número Configurado',
                'description' => 'Não há números de telefone associados à sua conta.',
                'actions' => [
                    '1. Acesse Meta for Developers',
                    '2. Vá para "API Setup" na sua app WhatsApp',
                    '3. Clique em "Add phone number"',
                    '4. Siga o processo de verificação'
                ]
            ];
        }

        return $recommendations;
    }

    /**
     * Teste apenas template (mais rápido)
     */
    public function sendTemplateTest(Request $request): JsonResponse
    {
        $testPhoneNumber = $request->get('phone') ?? config('services.whatsapp.test_phone_number') ?? '5551981388656';
        
        $result = $this->whatsAppService->sendTemplateMessage(
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