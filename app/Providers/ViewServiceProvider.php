<?php

namespace App\Providers;

use App\Models\ChatBot;
use App\Models\QuestionCategory;
use App\Models\Signage;
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
        View::composer("userPage.layout.layout", function ($view) {
            $view->with("licenses", LicenseType::all());
        });
        view::composer("userPage.layout.layout", function ($view) {
            $view->with("SignageType", SignageType::all());
        });
        view::composer("userPage.layout.layout", function ($view) {
            $view->with("chapter", QuestionCategory::first());
        });
        View::composer("userPage.layout.layout", function ($view) {
            $signages = Signage::all();
            foreach ($signages as $signage) {
                $signagesData[] = [
                    "SignageName" => $signage->SignageName,
                    "SignagesExplanation" => $signage->SignagesExplanation,
                    "SignageImage" => $signage->SignageImage,
                ];
            }
            if (!empty($signagesData)) {
                $view->with("signagesData", $signagesData);
            }
        });
        view::composer("userPage.layout.layout", function ($view) {
            $data = ChatBot::all();
            foreach ($data as $item) {
                $pdfs[] = [
                    "file" => $item->File
                ];
            }
            if(!empty($pdfs)){
            $view->with("pdfs", $pdfs);

            }
        });
    }
}
