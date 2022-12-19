<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
    public function boot()
    {
        if(app()->environment() != "production"){
            DB::listen(function($query){
                Log::debug(
                    Str::replaceArray('?', $query->bindings, $query->sql)
                );
            });
        }
    }
}
