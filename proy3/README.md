<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Proyecto 3

En el servidor EC2 donde está desplegado el proyecto, se necesita ejecutar un
comando Artisan diariamente a las 2:00 AM hora local. El comando es:

php artisan report:generate

## SOLUCION

### 1. Tecnicamente el cron job es una configuracion anivel de servidor (AWS una instancia EC2) que configura un trigger para que bajo un perido de tiempo especifico se genere una tarea determinada. Para el caso de AWS usamos un editor, generamos la configuracion solicitada

- crontab -e  
- 0 2 * * * cd /proy3 && php artisan report:generate >> /proy3/storage/logs/laravel.log 2>&1
- Explicacion de la configuracion:
    0 2 * * *: Programa la tarea diariamente a las 2:00 AM.
    cd /proy3: Navega al directorio donde está tu proyecto Laravel.
    php artisan report:generate: Ejecuta el comando Artisan.
    >>/proy3/storage/logs/laravel.log 2>&1: Guarda los logs de salida y errores en el archivo laravel.log.
- crontab -l //Confirma que el cron job se ha registrado
- php artisan report:generate //jecuta el comando para confirmar que funciona y este se generara todos los dias a las 2 AM


## 2. En el caso de Windows, para emular la ejecucion del cron job, se gestiono un archivo laravel_schedule.bat en el cual se coloca las instrucciones para ejecutar la configuracion tanto del schedule como del registro del reporte y se configuro un TaskSchedule para automatizar el llamamiento del .bat y de esa manera emular lo que se haria en un entorno AWS.  El archivo storage/logs/laravel.log posee las ejecuciones solicitadas segun la configuracion requerida

- es necesario generar el archivo Kernel.php bajo la ryuta app/Console/Kernel.php, el cual se coloca la instruccion a gestionar por el cron, la ruta donde registrara la ejecucion y si se diera un error un redireccionamiento a correo para comunicar la anomalia al usuario administrador

    <?php
    namespace App\Console;
    use Illuminate\Console\Scheduling\Schedule;
    use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
    class Kernel extends ConsoleKernel
    {
        /**  Register the commands for the application. */
        protected function commands(): void
        {
            $this->load(__DIR__.'/Commands');
            require base_path('routes/console.php');
        }
        /** Define the application's command schedule. */
        protected function schedule(Schedule $schedule)
        {
            $schedule->command('report:generate')->dailyAt('02:00')->sendOutputTo(storage_path('storage/logs/laravel.log'))->emailOutputOnFailure('xcalvas@gmail.com');
        }
    }

- Tambien es necesario generar el archivo GererateReport.php que se gestiona a traves del comando php artisan make:command GenerateReport, el cual creara el archivo GenerateReport.php en la ruta app/Console/Commands/GenerateReport.php, en el cual se especificara el tipo de reporte a generar y una descripcion narrativa para el reporte de las ejecuciones segun se ejecuten

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

- Comandos del archivo.bat
    @echo off
    cd C:\proy3
    php artisan schedule:run
    php artisan report:generate

