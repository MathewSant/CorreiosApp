<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Exportação</title>
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

        input[type="file"], select, input[type="text"] {
            display: block;
            margin: 10px auto;
            font-size: 16px;
            width: calc(100% - 40px);
            padding: 5px;
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

        .erro {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Verificação de Exportação</h1>
    
    <!-- Formulário para Upload de Foto -->
    <div class="form-container">
        <h2>Envie uma Foto do Objeto</h2>
        <form action="{{ route('verificar-objeto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="foto" accept="image/*" required>
            <select name="pais" required>
                <option value="" disabled selected>Selecione o país de destino</option>
                <option value="Brasil">Brasil</option>
                <option value="EUA">EUA</option>
                <option value="Alemanha">Alemanha</option>
                <!-- Adicione mais opções de países conforme necessário -->
            </select>
            <button type="submit">Verificar</button>
        </form>
    </div>

    <!-- Exibir Mensagens de Erro -->
    @if(session('erro'))
        <div class="erro">{{ session('erro') }}</div>
    @endif

    <!-- Exibir Resultado da Verificação -->
    @if(isset($nomeObjeto) && isset($informacoesExportacao))
        <div class="response">
            <h2>Resultado da Verificação</h2>
            <p><strong>Nome do Objeto:</strong> {{ $nomeObjeto }}</p>
            <p><strong>Tarifa de Exportação:</strong> {{ $informacoesExportacao['tarifa'] }}</p>
            <p><strong>Restrição:</strong> {{ $informacoesExportacao['restricao'] }}</p>
            <p><strong>Imposto:</strong> {{ $informacoesExportacao['imposto'] }}</p>
        </div>
    @endif

    <!-- Formulário para Gerar PDF com Informações do Usuário -->
    <div class="form-container">
        <h2>Gerar PDF com Dados de Envio</h2>
        <form action="{{ route('gerar-pdf') }}" method="POST">
            @csrf
            <input type="text" name="nome" placeholder="Nome/Empresa" required>
            <input type="text" name="cep" placeholder="CEP" required>
            <input type="text" name="endereco" placeholder="Endereço" required>
            <input type="text" name="numero" placeholder="Número" required>
            <input type="text" name="complemento" placeholder="Complemento">
            <input type="text" name="bairro" placeholder="Bairro" required>
            <input type="text" name="cidade" placeholder="Cidade" required>
            <input type="text" name="uf" placeholder="UF" required>
            <button type="submit">Gerar PDF</button>
        </form>
    </div>
</body>
</html>
