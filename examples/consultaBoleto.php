<?php

use VagKaefer\Sicoob\Facades\Boleto;
use VagKaefer\Sicoob\Models\SicoobBoleto;

$jsonConsulta = Boleto::consultarBoleto(nossoNumero: '4306');

$boleto = new SicoobBoleto();

$boleto->numeroContrato = $jsonConsulta->numeroContrato;
$boleto->modalidade = $jsonConsulta->modalidade;
$boleto->numeroContaCorrente = $jsonConsulta->numeroContaCorrente;
$boleto->especieDocumento = $jsonConsulta->especieDocumento;
$boleto->dataEmissao = $jsonConsulta->dataEmissao;
$boleto->nossoNumero = $jsonConsulta->nossoNumero;
$boleto->seuNumero = $jsonConsulta->seuNumero;
$boleto->identificacaoBoletoEmpresa = $jsonConsulta->identificacaoBoletoEmpresa;
$boleto->codigoBarras = $jsonConsulta->codigoBarras;
$boleto->linhaDigitavel = $jsonConsulta->linhaDigitavel;
$boleto->identificacaoEmissaoBoleto = $jsonConsulta->identificacaoEmissaoBoleto ?? null;
$boleto->identificacaoDistribuicaoBoleto = $jsonConsulta->identificacaoDistribuicaoBoleto ?? null;
$boleto->valor = $jsonConsulta->valor;
$boleto->dataVencimento = $jsonConsulta->dataVencimento;
$boleto->dataLimitePagamento = $jsonConsulta->dataLimitePagamento;
$boleto->valorAbatimento = $jsonConsulta->valorAbatimento;
$boleto->tipoDesconto = $jsonConsulta->tipoDesconto;
$boleto->dataPrimeiroDesconto = $jsonConsulta->dataPrimeiroDesconto ?? null;
$boleto->valorPrimeiroDesconto = $jsonConsulta->valorPrimeiroDesconto ?? null;
$boleto->dataSegundoDesconto = $jsonConsulta->dataSegundoDesconto ?? null;
$boleto->valorSegundoDesconto = $jsonConsulta->valorSegundoDesconto ?? null;
$boleto->dataTerceiroDesconto = $jsonConsulta->dataTerceiroDesconto ?? null;
$boleto->valorTerceiroDesconto = $jsonConsulta->valorTerceiroDesconto ?? null;
$boleto->tipoMulta = $jsonConsulta->tipoMulta;
$boleto->dataMulta = $jsonConsulta->dataMulta;
$boleto->valorMulta = $jsonConsulta->valorMulta;
$boleto->tipoJurosMora = $jsonConsulta->tipoJurosMora;
$boleto->dataJurosMora = $jsonConsulta->dataJurosMora;
$boleto->valorJurosMora = $jsonConsulta->valorJurosMora;
$boleto->numeroParcela = $jsonConsulta->numeroParcela;
$boleto->aceite = $jsonConsulta->aceite;
$boleto->codigoNegativacao = $jsonConsulta->codigoNegativacao ?? null;
$boleto->numeroDiasNegativacao = $jsonConsulta->numeroDiasNegativacao ?? null;
$boleto->codigoProtesto = $jsonConsulta->codigoProtesto ?? null;
$boleto->numeroDiasProtesto = $jsonConsulta->numeroDiasProtesto ?? null;
$boleto->quantidadeDiasFloat = $jsonConsulta->quantidadeDiasFloat ?? null;

// Pagador
$boleto->pagador_numeroCpfCnpj = $jsonConsulta->pagador['numeroCpfCnpj'];
$boleto->pagador_nome = $jsonConsulta->pagador['nome'];
$boleto->pagador_endereco = $jsonConsulta->pagador['endereco'];
$boleto->pagador_bairro = $jsonConsulta->pagador['bairro'];
$boleto->pagador_cidade = $jsonConsulta->pagador['cidade'];
$boleto->pagador_cep = $jsonConsulta->pagador['cep'];
$boleto->pagador_uf = $jsonConsulta->pagador['uf'];
$boleto->pagador_email = $jsonConsulta->pagador['email'][0];

// // beneficiarioFinal
$boleto->beneficiario_numeroCpfCnpj = $jsonConsulta->beneficiarioFinal['numeroCpfCnpj'];
$boleto->beneficiario_nome = $jsonConsulta->beneficiarioFinal['nome'];

// // mensagensInstrucao
$boleto->mensagem_linha1 = $jsonConsulta->mensagensInstrucao['mensagens'][0];
$boleto->mensagem_linha2 = $jsonConsulta->mensagensInstrucao['mensagens'][1];
$boleto->mensagem_linha3 = $jsonConsulta->mensagensInstrucao['mensagens'][2];
$boleto->mensagem_linha4 = $jsonConsulta->mensagensInstrucao['mensagens'][3];
$boleto->mensagem_linha5 = $jsonConsulta->mensagensInstrucao['mensagens'][4];

// // listaHistorico

$boleto->situacaoBoleto = $jsonConsulta->situacaoBoleto;

// // rateioCreditos
$boleto->qrCode = $jsonConsulta->qrCode ?? null;

$boleto->save();
