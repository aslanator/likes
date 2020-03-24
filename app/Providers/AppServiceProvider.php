<?php

namespace App\Providers;

use App\News;
use App\Photo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Passport::routes();
        Relation::morphMap([
            'news' => News::class,
            'photo' => Photo::class,
        ]);
    }
}
