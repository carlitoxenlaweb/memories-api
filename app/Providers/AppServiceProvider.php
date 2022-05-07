<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);
        JsonResource::withoutWrapping();
        
        Blade::directive('currency', function ($money) {
            return "<?php echo number_format((float)$money,2,',','.') . ' €'; ?>";
        });

		if(env('APP_ENV') == 'production') {
			$url->forceScheme('https');
		}
    }
}
