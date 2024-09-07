<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use GuzzleHttp\Client; // Para chamadas de API

class ExportacaoController extends Controller
{
    // Método para exibir o formulário
    public function index()
    {
        return view('exportacao');
    }

    // Método para processar o formulário e verificar o objeto
    public function verificarObjeto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:2048', // Limita o upload a imagens de até 2MB
            'pais' => 'required|string'
        ]);
    
        $fotoPath = $request->file('foto')->getRealPath();
        $pais = $request->input('pais');
    
        // Utilize a chave da API diretamente
        $apiKey = env('GOOGLE_VISION_API_KEY'); // Substitua pela chave de API
        $client = new Client();
    
        try {
            $response = $client->post('https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey, [
                'headers' => [
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'requests' => [
                        [
                            'image' => [
                                'content' => base64_encode(file_get_contents($fotoPath)),
                            ],
                            'features' => [
                                [
                                    'type' => 'LABEL_DETECTION',
                                    'maxResults' => 1,
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
            $nomeObjeto = $data['responses'][0]['labelAnnotations'][0]['description'];
    
            // Consultar informações de exportação
            $informacoesExportacao = $this->obterInformacoesExportacao($nomeObjeto, $pais);
    
            return view('exportacao', [
                'nomeObjeto' => $nomeObjeto,
                'informacoesExportacao' => $informacoesExportacao
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('erro', 'Erro ao processar imagem: ' . $e->getMessage());
        }
    }
    

    private function obterInformacoesExportacao($nomeObjeto, $pais)
    {
        return [
            'tarifa' => '10%',
            'restricao' => 'Proibido enviar bebidas alcoólicas para ' . $pais,
            'imposto' => '20%'
        ];
    }

    public function gerarPDF(Request $request)
    {
        $dados = $request->all();
    
        $imagePath = public_path('public/images/correios.jpeg'); // Certifique-se de que o caminho esteja correto
    
        $html = "
        <h1>Dados de Envio</h1>
        <img src='{$imagePath}' alt='Logo dos Correios' style='width: 150px; height: auto;' />
        <p><strong>Nome/Empresa:</strong> {$dados['nome']}</p>
        <p><strong>CEP:</strong> {$dados['cep']}</p>
        <p><strong>Endereço:</strong> {$dados['endereco']}, {$dados['numero']}</p>
        <p><strong>Complemento:</strong> {$dados['complemento']}</p>
        <p><strong>Bairro:</strong> {$dados['bairro']}</p>
        <p><strong>Cidade:</strong> {$dados['cidade']}</p>
        <p><strong>UF:</strong> {$dados['uf']}</p>
        ";
    
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        return $dompdf->stream('dados_envio.pdf');
    }
    
    
}
