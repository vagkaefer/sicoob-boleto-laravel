<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSicoobBoletosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sicoob_boletos', function (Blueprint $table) {

      // $table->id(); //Uncomment if you doesn't use uuid
      $table->uuid('id')->primary(); //Comment if you doesn't use uuid

      $table->integer('numeroContrato')->nullable(); //Número que identifica o contrato do beneficiário.
      $table->integer('modalidade')->nullable(); //úmero que identifica a modalidade do boleto. - 1 SIMPLES COM REGISTRO - 5 CARNÊ DE PAGAMENTOS - 6 INDEXADA - 14 CARTÃO DE CRÉDITO
      $table->integer('numeroContaCorrente')->nullable(); //Número da Conta Corrente para crédito do boleto.
      $table->string('especieDocumento')->nullable(); //Espécie do documento - Ver função translate_especieDocumento()
      $table->timestamp('dataEmissao'); //Data de emissão do boleto
      $table->integer('nossoNumero'); //Número que identifica o boleto.
      $table->string('seuNumero', 18)->nullable(); //Informar o número que identifica o boleto no sistema do beneficiário. `Tamanho máximo 18`
      $table->string('identificacaoBoletoEmpresa')->nullable(); //Destinado para uso da Empresa Cedente para identificação do Boleto
      $table->string('codigoBarras', 44); //Número de código de barras do boleto com 44 posições.
      $table->string('linhaDigitavel', 47); //Número da linha digitável do boleto com 47 posições.
      $table->integer('identificacaoEmissaoBoleto')->nullable(); //Identificação de Emissão do Boleto - 1 Banco Emite - 2 Cliente Emite
      $table->integer('identificacaoDistribuicaoBoleto')->nullable(); //Identificação de Distribuição do Boleto - 1 Banco Distribui - 2 Cliente Distribui
      $table->decimal('valor', 9, 3); //Valor nominal do boleto.
      $table->timestamp('dataVencimento'); //Data de vencimento do boleto.
      $table->timestamp('dataLimitePagamento'); //Data de limite para pagamento do boleto.
      $table->decimal('valorAbatimento', 9, 3)->nullable(); //Valor do abatimento.
      $table->integer('tipoDesconto'); //Espécie do documento - Ver função translate_tipoDesconto()
      $table->timestamp('dataPrimeiroDesconto')->nullable(); //Data do primeiro desconto.
      $table->decimal('valorPrimeiroDesconto', 9, 3)->nullable(); //Valor do primeiro desconto
      $table->timestamp('dataSegundoDesconto')->nullable(); //Data do segundo desconto
      $table->decimal('valorSegundoDesconto', 9, 3)->nullable(); //Valor do segundo desconto
      $table->timestamp('dataTerceiroDesconto')->nullable(); //Valor do terceiro desconto
      $table->decimal('valorTerceiroDesconto', 9, 3)->nullable(); //Valor do terceiro desconto
      $table->integer('tipoMulta'); //Tipo de Multa - 0 Isento - 1 Valor Fixo - 2 Percentual
      $table->timestamp('dataMulta')->nullable(); //Deve ser maior que a data de vencimento do boleto e menor ou igual que data limite de pagamento.
      $table->decimal('valorMulta', 9, 3)->nullable(); //Valor da multa.
      $table->integer('tipoJurosMora')->nullable(); //Tipo de Juros de Mora - 2 Taxa Mensal - 3 Isento
      $table->timestamp('dataJurosMora')->nullable(); //Deve ser maior que a data de vencimento do boleto e menor ou igual que data limite de pagamento.
      $table->decimal('valorJurosMora', 9, 3)->nullable(); //Valor do Juros de Mora.
      $table->integer('numeroParcela')->nullable(); //Número da parcela.
      $table->boolean('aceite'); //Identificador do aceite do boleto.
      $table->integer('codigoNegativacao')->nullable(); //Código de Negativação do Boleto - 2 Negativar Dias Úteis - 3 Não Negativar
      $table->integer('numeroDiasNegativacao')->nullable(); //Número de Dias para Negativação do Boleto
      $table->integer('codigoProtesto')->nullable(); //Código de Protesto do Boleto - 1 Protestar Dias Corridos - 2 Protestar Dias Úteis - 3 Não Protestar
      $table->integer('numeroDiasProtesto')->nullable(); //Número de Dias para Protesto do Boleto
      $table->integer('quantidadeDiasFloat')->nullable(); //Quantidade de Dias de Float.

      // pagador
      $table->string('pagador_numeroCpfCnpj', 14); //CPF ou CNPJ do pagador. `Tamanho máximo 14`
      $table->string('pagador_nome', 50); //Nome completo do pagador. `Tamanho máximo 50`
      $table->string('pagador_endereco');
      $table->string('pagador_bairro');
      $table->string('pagador_cidade');
      $table->string('pagador_cep');
      $table->string('pagador_uf');
      $table->string('pagador_email');

      // beneficiarioFinal
      $table->string('beneficiario_numeroCpfCnpj', 14); //CPF ou CNPJ do Beneficário Final. Antigo Sacador Avalista. `Tamanho máximo 14`
      $table->string('beneficiario_nome', 50); //Nome do Beneficário Final. Antigo Sacador Avalista. `Tamanho máximo 50`

      // mensagensInstrucao
      $table->string('mensagem_linha1')->nullable();
      $table->string('mensagem_linha2')->nullable();
      $table->string('mensagem_linha3')->nullable();
      $table->string('mensagem_linha4')->nullable();
      $table->string('mensagem_linha5')->nullable();

      // listaHistorico

      $table->string('situacaoBoleto'); //Descreve a Situação atual do Boleto - Em Aberto - Baixado - Liquidado

      // rateioCreditos
      $table->text('qrCode')->nullable(); //Descreve a Situação atual do Boleto - Em Aberto - Baixado - Liquidado

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('sicoob_boletos');
  }
}
