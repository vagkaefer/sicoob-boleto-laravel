<?php

namespace VagKaefer\SicoobBoleto;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class SicoobBoleto
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

        dd($json);
        // } catch (ClientException $e) {
        //     // $response = $e->getResponse();
        //     // echo $response->getBody()->getContents();
        //     dd($e);
        // }
    }
}
