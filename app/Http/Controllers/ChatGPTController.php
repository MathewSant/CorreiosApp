<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Parsedown;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Smalot\PdfParser\Parser; // Importa a biblioteca Smalot PDF Parser

class ChatGPTController extends Controller
{
     // Método para exibir a página inicial
     public function index()
     {
         return view('index'); // Carrega a view inicial onde o usuário escolhe o tipo de acesso
     }
    public function correios()
    {
        $apiKey = env('OPENAI_API_KEY'); // Acesse sua chave de API de forma segura
        $client = new Client();

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => 'Olá, como você está?']
                    ],
                    'max_tokens' => 150
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return view('chatgpt-response', ['response' => $data['choices'][0]['message']['content']]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            if ($statusCode == 429) {
                return 'Limite de requisições excedido. Tente novamente mais tarde.';
            } else {
                return 'Erro ao chamar a API: ' . $e->getMessage();
            }
        } catch (\Exception $e) {
            return 'Erro ao chamar a API: ' . $e->getMessage();
        }
    }

    public function processarPDF(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);
    
        $pdfPath = $request->file('pdf')->getRealPath();
    
        $parser = new Parser();
        $documento = $parser->parseFile($pdfPath);
        $textoExtraido = $documento->getText();
    
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();
    
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Você é um assistente para funcionários dos Correios. Sua tarefa é resumir documentos PDF para que sejam facilmente compreendidos pelos funcionários, destacando os pontos mais importantes e removendo informações desnecessárias.'
                        ],
                        [
                            'role' => 'user',
                            'content' => 'Resuma o seguinte texto: ' . $textoExtraido
                        ]
                    ],
                    'max_tokens' => 150
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
            $parsedown = new Parsedown();
            $htmlContent = $parsedown->text($data['choices'][0]['message']['content']);
    
            return redirect()->back()->with('response_pdf', $htmlContent);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->back()->with('response_pdf', 'Erro ao chamar a API: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('response_pdf', 'Erro ao chamar a API: ' . $e->getMessage());
        }
    }
    
    public function processarExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls|max:2048',
        ]);
    
        $excelPath = $request->file('excel')->getRealPath();
    
        $spreadsheet = IOFactory::load($excelPath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
    
        $conteudoPlanilha = json_encode($data);
    
        $apiKey = env('OPENAI_API_KEY');
        $client = new Client();
    
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Você é um assistente de análise de dados para funcionários dos Correios. Sua tarefa é analisar dados de planilhas Excel e gerar métricas e insights interessantes, formatando a resposta em Markdown para melhor legibilidade.'
                        ],
                        [
                            'role' => 'user',
                            'content' => 'Analise os dados da seguinte planilha e gere métricas interessantes formatadas como uma lista em Markdown: ' . $conteudoPlanilha
                        ]
                    ],
                    'max_tokens' => 500
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
            $parsedown = new Parsedown();
            $htmlContent = $parsedown->text($data['choices'][0]['message']['content']);
    
            return redirect()->back()->with('response_excel', $htmlContent);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->back()->with('response_excel', 'Erro ao chamar a API: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('response_excel', 'Erro ao chamar a API: ' . $e->getMessage());
        }
    }

      }
    

