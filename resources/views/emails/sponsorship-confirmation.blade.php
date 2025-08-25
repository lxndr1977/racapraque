<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmação de Apadrinhamento</title>
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
        .btn {
            display: inline-block;
            background-color: #b2567e;
            color: white !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 16px;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #b2567e;
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
            
            <p>Você acaba de registrar sua intenção de apadrinhamento que vai transformar completamente a vida {{ $genderedPreposition }} <strong>{{ $animalName }}</strong>.</p>
            
            <p>{{ ucfirst($genderedName) }} está prestes a ganhar um anjo da guarda! Seu apoio vai garantir que {{ $genderedName }} receba todo o cuidado, carinho e proteção que merece, até o dia em que {{ $genderedPronoun }} encontre uma família para sempre.</p>

            <div class="details">
                <h3>Detalhes da Intenção de Apadrinhamento</h3>
                <p><strong>Animal:</strong> {{ $animalName }}</p>
                <p><strong>Valor:</strong> R$ {{ number_format($amount, 2, ',', '.') }} / {{ $recurrenceDays}}</p>
                <p><strong>Data:</strong> {{ $sponsorship->created_at->format('d/m/Y H:i') }}</p>

                <p><strong>Caso ainda não tenha efetuado o pagamento</strong>, clique no botão abaixo para finalizar seu apadrinhamento. Se já pagou, pode desconsiderar esta mensagem.</p>

                <a href="{{ $paymentLink }}" class="btn">Efetuar pagamento</a>
            </div>

            <p>Assim que identificarmos o pagamento, enviaremos um email de confirmação para você.</p>

            <p>Para dúvidas, nossa equipe está sempre à disposição.</p>

            <p>Com todo nosso carinho e gratidão,<br>
            <strong>Equipe Raça Pra Quê?</strong></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Associação Raça Pra Quê. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>