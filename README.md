<h1 style="color:red">ESSE PACOTE ESTÁ EM ALPHA, ou seja, NÃO UTILIZE ELE AINDA, AGUARDE A VERSÃO 1.0 Beta</h1>

# Sicoob boleto laravel

Um pacote para integrar seus sistema Laravel com a API de Cobrança Bancária V2 do Sicoob.

### Informações importantes ###

Esse pacote utiliza APIs, ou seja, não são utilizadas remessas de envio e retorno!

A Cobrança Bancária V2 do Sicoob requer a utilização de certificado digital emitido por uma entidade certificadora ICP Brasil e deve ser emitido para o CNPJ do cooperado, quando PJ (Pessoa Jurídica) e para CPF do cooperado quando PF (Pessoa Física).

Antes de utilizar esse pacote, leia e entenda todas as instruções da documentação oficial do Sicoob: https://developers.sicoob.com.br/#!/documentacao 

O Sicoob também fornece uma coleção da API de Cobrança Bancária para utilização no Postman: https://developers.sicoob.com.br/images/postman/CobrancaBancaria.postman_collection 

### Doações ###

**Estamos em busca de *doadores* e *patrocinadores* para ajudar a financiar parte do desenvolvimento deste pacote** 

Este é um projeto totalmente *OpenSource*, para usa-lo, copia-lo e modifica-lo você não paga absolutamente nada. Porém para continuarmos a mante-lo de forma adequada é necessária alguma contribuição seja feita, seja auxiliando na codificação, na documentação, na realização de testes, além da identificação e correção de falhas.

Mas também, caso você ache que qualquer informação obtida aqui, lhe foi útil e que isso vale de algum dinheiro e está disposto a doar algo, sinta-se livre para enviar qualquer quantia, seja diretamente ao autor ou através do PayPal.

<div align="center">

 <!-- empty table header -->
 <a style="margin-right:50px" target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=KJTYG92HKWMF2">
 <img style="margin-bottom:15px;"  alt="Doar com Paypal" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif"/>
 </a>

*Agradecemos a sua contribuição! ;)*
</div>


### Requisitos ###

Versão Laravel: 9 ou superior

Versão do PHP: 8.1 ou superior

### Funcionalidades ###

#### Disponíveis ####

- Geração de Token

#### Em Desenvolvimento ####

- Consulta de boletos
- Inclusão de boletos

### Instruções de uso ###

#### Geral ####

TODO

As informações completas estão disponíveis na [Wiki](https://github.com/vagkaefer/sicoob-boleto-laravel/wiki) desse repositório

#### Configuração #### 

Publique o arquivo de configuração

    php artisan vendor:publish --provider="VagKaefer\SicoobBoleto\SicoobBoletoServiceProvider" --tag="config"

Configure seus dados no arquivo .env (Recomendado) ou no arquivo config/sicoob-boleto.php

    SB_CLIENT_ID=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx

    SB_CERTIFICATE_FILE=/certificates/CPF_CNPJ.pfx

    SB_CERTIFICATE_PASSWORD=SenhaDoCertificado

#### Comandos disponíveis (php artisan) #### 

- **sicoob-boletos:update-status**  Atualiza os status dos boletos em aberto