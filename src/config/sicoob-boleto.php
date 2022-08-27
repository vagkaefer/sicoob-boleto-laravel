<?php

return [
  'sb_auth_url' => env('SB__AUTH_URL', 'https://auth.sicoob.com.br/'), //In this moment, we don't have Sandbox
  'sb_api_url' => env('SB__AUTH_URL', 'https://api.sicoob.com.br/'), //In this moment, we don't have Sandbox
  'sb_certificate_file' => env('SB_CERTIFICATE_FILE', null),
  'sb_certificate_password' => env('SB_CERTIFICATE_PASSWORD', null),
  'sb_client_id' => env('SB_CLIENT_ID', null),
  'sb_scope' => env('SB_SCOPE', 'cobranca_boletos_consultar cobranca_boletos_incluir cobranca_boletos_pagador cobranca_boletos_baixa cobranca_pagadores cobranca_boletos_solicitacao_movimentacao_incluir cobranca_boletos_solicitacao_movimentacao_consultar cobranca_boletos_solicitacao_movimentacao_download'),
];
