<?php

namespace VagKaefer\Sicoob;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class Boleto
{
    protected $token;
    protected $numeroContrato;
    protected $authClientWithCert;
    protected $apiClientWithCert;

    public function __construct()
    {
        $this->token = Cache::get('sicoob-boleto-token');

        $this->authClientWithCert = new Client(
            [
                'base_uri' => config('sicoob-boleto.sb_auth_url'),
                'cert'     => [config('sicoob-boleto.sb_certificate_file'), config('sicoob-boleto.sb_certificate_password')],
                'curl'     => [CURLOPT_SSLCERTTYPE => 'P12'], // to define it's a PFX key
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept'     => 'application/json',
                    'Accept-Encoding'      => 'gzip, deflate, br',
                    'Connection'     => 'keep-alive',
                ]
            ]
        );

        if ($this->token == null) {
            $this->request_token();
        }

        $this->numeroContrato = config('sicoob-boleto.sb_numero_contrato');

        $this->apiClientWithCert = new Client(
            [
                'base_uri' => config('sicoob-boleto.sb_api_url'),
                'cert'     => [config('sicoob-boleto.sb_certificate_file'), config('sicoob-boleto.sb_certificate_password')],
                'curl'     => [CURLOPT_SSLCERTTYPE => 'P12'], // to define it's a PFX key
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept'     => 'application/json',
                    'Accept-Encoding'      => 'gzip, deflate, br',
                    'Authorization' => $this->token->token_type . ' ' . $this->token->access_token,
                    'Connection'     => 'keep-alive',
                ]
            ]
        );
    }

    private function save_token($json)
    {

        $token = (object)[
            'token_type' => $json['token_type'],
            'access_token' => $json['access_token'],
        ];

        $this->token = $token;
        Cache::put('sicoob-boleto-token', $token, $json['expires_in']);
    }

    private function request_token()
    {
        // TODO do, make tests and error handling

        try {

            $response = $this->authClientWithCert->request('POST', 'auth/realms/cooperado/protocol/openid-connect/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('sicoob-boleto.sb_client_id'),
                    'scope' => config('sicoob-boleto.sb_scope'),
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept'     => 'application/json',
                    'Accept-Encoding'      => 'gzip, deflate, br',
                ]
            ]);

            $json = json_decode($response->getBody(), true);

            $this->save_token($json);
        } catch (ClientException $e) {
            // $response = $e->getResponse();
            echo $response->getBody()->getContents();
        }
    }

    private function refresh_token()
    {
    }

    public function consultarBoleto(
        string $modalidade = null,
        string $linhaDigitavel = null,
        string $codigoBarras = null,
        string $nossoNumero = null
    ) {

        if ($modalidade == null) {
            $modalidade = 1; //Simples com Registro
            // $modalidade = 5; // 5 Carn?? de pagamentos
            // $modalidade = 6; // 6 Indexada
            // $modalidade = 14; // 14 Cart??o de cr??dito
        }

        // try {
        $response = $this->apiClientWithCert->request(
            'GET',
            'boletos',
            [
                'query' => [
                    'codigoBarras' => $codigoBarras,
                    'linhaDigitavel' => $linhaDigitavel,
                    'modalidade' => $modalidade,
                    'numeroContrato' => $this->numeroContrato,
                    'nossoNumero' => $nossoNumero,
                ]
            ]
        );

        $json = json_decode($response->getBody(), true);
        return (object)$json['resultado'];
    }

    public function translate_especieDocumento($especieDocumento)
    {

        switch ($especieDocumento) {

            case 'CH':
                return "Cheque";
                break;

            case 'DM':
                return "Duplicata Mercantil";
                break;

            case 'DMI':
                return "Duplicata Mercantil Indica????o";
                break;

            case 'DS':
                return "Duplicata de Servi??o";
                break;

            case 'DSI':
                return "Duplicata Servi??o Indica????o";
                break;

            case 'DR':
                return "Duplicata Rural";
                break;

            case 'LC':
                return "Letra de C??mbio";
                break;

            case 'NCC':
                return "Nota de Cr??dito Comercial";
                break;

            case 'NCE':
                return "Nota de Cr??dito Exporta????o";
                break;

            case 'NCI':
                return "Nota de Cr??dito Industrial";
                break;

            case 'NCR':
                return "Nota de Cr??dito Rural";
                break;

            case 'NP':
                return "Nota Promiss??ria";
                break;

            case 'NPR':
                return "Nota Promiss??ria Rural";
                break;

            case 'TM':
                return "Triplicata Mercantil";
                break;

            case 'TS':
                return "Triplicata de Servi??o";
                break;

            case 'NS':
                return "Nota de Seguro";
                break;

            case 'FAT':
                return "Fatura";
                break;

            case 'ND':
                return "Nota de D??bito";
                break;

            case 'RC':
                return "Recibo";
                break;

            case 'AP':
                return "Ap??lice de Seguro";
                break;

            case 'ME':
                return "Mensalidade Escolar";
                break;

            case 'PC':
                return "Pagamento de Cons??rcio";
                break;

            case 'NF':
                return "Nota Fiscal";
                break;

            case 'DD':
                return "Documento de D??vida";
                break;

            case 'CC':
                return "Cart??o de Cr??dito";
                break;

            case 'BDP':
                return "Boleto Proposta";
                break;

            case 'OU':
                return "Outros";
                break;
        }
    }

    public function translate_tipoDesconto($especieDocumento)
    {

        switch ($especieDocumento) {

            case 0:
                return "Sem Desconto";
                break;

            case 1:
                return "Valor Fixo At?? a Data Informada";
                break;

            case 2:
                return "Percentual at?? a data informada";
                break;

            case 3:
                return "Valor por antecipa????o dia corrido";
                break;

            case 4:
                return "Valor por antecipa????o dia ??til";
                break;

            case 5:
                return "Percentual por antecipa????o dia corrido";
                break;

            case 6:
                return "Percentual por antecipa????o dia ??til";
                break;
        }
    }
}
