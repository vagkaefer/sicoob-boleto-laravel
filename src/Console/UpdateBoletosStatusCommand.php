<?php

namespace VagKaefer\SicoobBoleto\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateBoletosStatusCommand extends Command
{
  protected $signature = 'sicoob-boletos:update-status';

  protected $description = 'Atualiza os status dos boletos';

  public function handle()
  {
    $this->info('Fazer a função aqui...');
  }
}
