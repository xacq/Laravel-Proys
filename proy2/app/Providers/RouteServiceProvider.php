<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El espacio de nombres para los controladores de la API.
     *
     * @var string
     */
    public const API_NAMESPACE = 'App\\Http\\Controllers';

    /**
     * Defina las rutas para la aplicación.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mapApiRoutes();
    }

    /**
     * Mapea las rutas de la API.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace(self::API_NAMESPACE) 
             ->group(base_path('routes/api.php'));
    }
}
