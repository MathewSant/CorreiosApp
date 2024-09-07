<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Escolha seu Acesso</title>
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
            justify-content: center;
            min-height: 100vh;
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            background-color: #FFCC00; /* Amarelo dos Correios */
            color: #005CA9; /* Azul dos Correios */
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 10px;
        }

        button:hover {
            background-color: #e6b800; /* Sombra do Amarelo dos Correios */
        }
    </style>
</head>
<body>
    <h1>Bem-vindo ao Sistema dos Correios</h1>
    <p>Por favor, selecione o seu tipo de acesso:</p>

    <div class="button-container">
        <!-- Botão para Usuário -->
        <a href="{{ route('verificar-objeto') }}">
            <button>Usuário</button>
        </a>

        <!-- Botão para Funcionário dos Correios -->
        <a href="{{ route('funcionario-correios') }}">
            <button>Funcionário dos Correios</button>
        </a>
    </div>
</body>
</html>
