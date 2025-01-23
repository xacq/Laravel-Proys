<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    //DEFINO LOS PARAMETROS PARA EL CRON JOB
    protected function schedule(Schedule $schedule)
    {        //DETERMINO EL COMANDO, LA HORA, LAUBICACION DEL REGISTRO Y EL CORREO PARA GESTIONAR UNA ANOMALIA
        $schedule->command('report:generate')
                 ->dailyAt('02:00')
                 ->sendOutputTo(storage_path('storage/logs/laravel.log'))
                 ->emailOutputOnFailure('xcalvas@gmail.com');
    }

}
