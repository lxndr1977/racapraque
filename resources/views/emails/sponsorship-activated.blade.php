<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Obrigado pelo seu apadrinhamento!</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.5;
            color: #333;
            background-color: #fafafa;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }
        .content {
            margin: 24px 0;
        }
        p {
            margin: 16px 0;
            color: #4a4a4a;
            font-size: 16px;
        }
        .details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 24px 0;
            border: 1px solid #e9ecef;
        }
        .details h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 12px 0;
            color: #1a1a1a;
        }
        .details p {
            margin: 8px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #f0f0f0;
            color: #888;
            font-size: 13px;
            line-height: 1.4;
        }
        strong {
            color: #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ $message->embed(public_path('images/logo-raca-pra-que.png')) }}" alt="Logo" style="max-width: 120px; height: auto; margin-bottom: 16px;">

        <div class="content">
            <p>Olá, <strong>{{ $sponsorName }}</strong>.</p>
            
            <p>Que alegria imensa poder compartilhar esta notícia com você! Seu apadrinhamento foi <strong>ativado com sucesso</strong> e agora <strong>{{ $genderedName }}</strong> oficialmente tem um anjo da guarda!</p>
            
            <div class="details">
                <h3>Detalhes do seu apadrinhamento ativo</h3>
                <p><strong>Animal:</strong> {{ $animalName }}</p>
                <p><strong>Despesa:</strong> {{ $expenseName }}</p>
                <p><strong>Valor:</strong> R$ {{ number_format($amount, 2, ',', '.') }}</p>
                <p><strong>Status:</strong> <strong style="color: #28a745;">ATIVO ✓</strong></p>
            </div>

            <p>Nossa equipe está emocionada em tê-lo(a) como padrinho/madrinha oficial. Você receberá atualizações sobre o progresso e bem-estar {{ $genderedPreposition }} {{ $genderedName }}.</p>

            <p>Mais uma vez, nosso coração transborda de gratidão por você ter escolhido fazer parte da nossa família!</p>

            <p>Com todo nosso carinho e gratidão,<br>
            <strong>Equipe Raça Pra Quê?</strong></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Associação Raça Pra Quê. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>