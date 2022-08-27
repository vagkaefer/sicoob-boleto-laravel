<?php

namespace VagKaefer\SicoobBoleto;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class SicoobBoleto
{
    protected $token;

    protected $clientWithCert;

    public function __construct()
    {
        $this->token = Cache::get('sicoob-boleto-token');

        $this->clientWithCert = new Client(
            [
                'base_uri' => config('sicoob-boleto.sb_auth_url'),
                'cert'     => [config('sicoob-boleto.sb_certificate_file'), config('sicoob-boleto.sb_certificate_password')],
                'curl'     => [CURLOPT_SSLCERTTYPE => 'P12'], // to define it's a PFX key
            ]
        );

        if ($this->token == null) {
            $this->request_token();
        }
    }

    public function save_token($json)
    {

        $token = (object)[
            'token_type' => $json['token_type'],
            'access_token' => $json['access_token'],
        ];

        $this->token = $token;
        Cache::put('sicoob-boleto-token', $token, $json['expires_in']);
    }

    public function request_token()
    {
        // Todo do, make tests and error handling

        try {

            $response = $this->clientWithCert->request('POST', 'auth/realms/cooperado/protocol/openid-connect/token', [
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

    public function get_token()
    {
        dd($this->token);
    }

    public function refresh_token()
    {
    }
}
