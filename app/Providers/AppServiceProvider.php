<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('rupiah', function ($expression) {
            // Fungsi number_format(angka, desimal, pemisah_desimal, pemisah_ribuan)
            // number_format($expression, 0, ',', '.') akan menghasilkan format 1.500.000
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });
    }
}
