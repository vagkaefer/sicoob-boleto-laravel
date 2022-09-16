<?php

namespace VagKaefer\Sicoob\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateBoletosStatusCommand extends Command
{
  protected $signature = 'sicoob-boletos:update-status';

  protected $description = 'Atualiza os status dos boletos em aberto';

  public function handle()
  {
    $this->info('Fazer a função aqui...');
  }
}
