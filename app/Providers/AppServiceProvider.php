<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('user', function ($attribute, $value, $parameters, $validator) {
            // Implementasi validasi kustom di sini
            // Misalnya, Anda dapat memeriksa apakah nilai berada di antara batas yang diizinkan
            return $value == 'user'; // Contoh sederhana, bisa disesuaikan dengan kebutuhan Anda
        });
    }
}
