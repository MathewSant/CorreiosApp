<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatização de Documentos dos Correios</title>
    <style>
        /* Estilos Globais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        h1, h2 {
            color: #005CA9; /* Azul dos Correios */
            margin-bottom: 20px;
        }

        /* Estilo dos Formulários */
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-bottom: 30px;
        }

        input[type="file"] {
            display: block;
            margin: 20px auto;
            font-size: 16px;
        }

        button {
            background-color: #FFCC00; /* Amarelo dos Correios */
            color: #005CA9; /* Azul dos Correios */
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e6b800; /* Sombra do Amarelo dos Correios */
        }

        /* Estilo da Resposta */
        .response {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
            text-align: left; /* Alinha o texto à esquerda */
        }

        p {
            font-size: 18px;
            color: #333;
        }

        ul, ol {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Automatização de Documentos dos Correios</h1>
    
    <!-- Formulário para Upload de PDF -->
    <div class="form-container">
        <h2>Resumo de Documentos PDF</h2>
        <p>Carregue um documento PDF para gerar um resumo automático, destacando os pontos mais importantes.</p>
        <form action="{{ route('processar-pdf') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf" accept=".pdf" required>
            <button type="submit">Enviar PDF</button>
        </form>
    </div>

    <!-- Exibir Resposta de PDF -->
    @if(session('response_pdf'))
        <div class="response">
            <h2>Resultado do PDF:</h2>
            {!! session('response_pdf') !!}
        </div>
    @endif

    <!-- Formulário para Upload de Excel -->
    <div class="form-container">
        <h2>Análise de Planilhas Excel</h2>
        <p>Carregue uma planilha Excel para gerar métricas e insights baseados nos dados fornecidos.</p>
        <form action="{{ route('processar-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel" accept=".xlsx, .xls" required>
            <button type="submit">Enviar Excel</button>
        </form>
    </div>

    <!-- Exibir Resposta de Excel -->
    @if(session('response_excel'))
        <div class="response">
            <h2>Resultado do Excel:</h2>
            {!! session('response_excel') !!}
        </div>
    @endif
</body>
</html>
