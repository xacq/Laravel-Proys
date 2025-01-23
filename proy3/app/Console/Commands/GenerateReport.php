<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log; 

class GenerateReport extends Command
{
    // Nombre del comando
    protected $signature = 'report:generate';

    // Descripción del comando
    protected $description = 'Genera un informe diario';

    // Lógica del comando
    public function handle()
    {
        // Aquí implementa la lógica para generar el informe.
        Log::info('El informe diario se ha generado correctamente.');
    }
}
