# Projeto Laravel - Automatização de Processos dos Correios

Este projeto Laravel visa automatizar diversos processos para os funcionários e usuários dos Correios, incluindo o resumo de documentos PDF, análise de dados em planilhas Excel, e verificação de objetos para exportação utilizando a API de reconhecimento de imagem do Google Vision.

## Funcionalidades

1. *Resumo de Documentos PDF*: Os usuários podem fazer upload de arquivos PDF, que serão processados e resumidos automaticamente para fácil compreensão.
2. *Análise de Planilhas Excel*: Os usuários podem enviar arquivos Excel e obter métricas e insights úteis baseados nos dados fornecidos.
3. *Verificação de Objetos para Exportação*: Utiliza a API do Google Vision para identificar objetos em uma imagem enviada e verificar a viabilidade de exportação do objeto, mostrando tarifas, restrições e impostos.
4. *Geração de PDF com Dados de Envio*: Gera um PDF com os dados de envio inseridos pelo usuário, simulando um documento dos Correios.

## Tecnologias Utilizadas

- *Laravel*: Framework PHP para construção do back-end da aplicação.
- *Dompdf*: Biblioteca PHP para geração de PDFs.
- *Google Vision API*: API para reconhecimento de imagens.
- *Guzzle*: Biblioteca HTTP cliente para requisições HTTP, usada para comunicação com a Google Vision API.
- *PhpSpreadsheet*: Biblioteca PHP para leitura e manipulação de planilhas Excel.

## Pré-requisitos

- PHP >= 7.4
- Composer
- Laravel 8.x ou superior
- Chave de API para o Google Vision

## Instalação
1. *Clone o repositório:*
   ```bash
   git clone https://github.com/seuusuario/seurepositorio.git
   cd seurepositorio
