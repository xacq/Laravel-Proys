<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     *
     * @var string
     */
    public const API_NAMESPACE = 'App\\Http\\Controllers';

    /**
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mapApiRoutes();
    }

    /**
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        //Registro la route para el api    
        Route::prefix('api')
             ->middleware('api')
             ->namespace(self::API_NAMESPACE) 
             ->group(base_path('routes/api.php'));
    }
}
