<?php

namespace App\Providers;

use App\Models\QuestionCategory;
use App\Models\SignageType;
use Illuminate\Support\ServiceProvider;
use App\Models\LicenseType;
use View;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer("userPage.layout.layout",function($view){
            $view->with("licenses",LicenseType::all());
        });
        view::composer("userPage.layout.layout", function($view){
            $view->with("SignageType", SignageType::all());
        });
        view::composer("userPage.layout.layout",function($view){
            $view->with("chapters",QuestionCategory::all());
        });
    }
}
