<?php

namespace App\Providers;

use App\Company;
use App\UserGeneralSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\URL;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        /*if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            URL::forceScheme('https');
        }*/
        //setting language
        if(isset($_COOKIE['language'])) {
            \App::setLocale($_COOKIE['language']);
        } else {
            \App::setLocale('en');
        }
        //get general setting value
        $general_setting = DB::table('general_settings')->latest()->first();
        $currency = \App\Currency::find($general_setting->currency);
        View::share('general_setting', $general_setting);
        View::share('currency', $currency);
        config(['staff_access' => $general_setting->staff_access, 'date_format' => $general_setting->date_format, 'currency' => $currency->code, 'currency_position' => $general_setting->currency_position]);

        $alert_product = DB::table('products')->where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->count();
        View::share('alert_product', $alert_product);
        Schema::defaultStringLength(191);

        view()->composer('*', function($view) {
            if(Auth::check()) {
                foreach(json_decode(Auth::user()->company_id ?? '[]') as $companyId) {
                    $lims_company_list[] = Company::where('id', $companyId)
                        ->where('is_active', true)
                        ->first();
                }
                $userGeneralSetting = UserGeneralSetting::with('company')
                    ->where('user_id', Auth::user()->id)
                    ->first();

                if($userGeneralSetting) {
                    $view->with('userGeneralSetting', $userGeneralSetting);
                } else {
                    UserGeneralSetting::create([
                        "user_id" => Auth::user()->id,
                        "role_id" => Auth::user()->role_id,
                        "company_id" => Auth::user()->default_company_id,
                        "warehouse_id" => Auth::user()->default_warehouse_id,
                    ]);

                    $userGeneralSetting = UserGeneralSetting::with('company')
                        ->where('user_id', Auth::user()->id)
                        ->first();

                    $view->with('userGeneralSetting', $userGeneralSetting);
                }

                $view->with('lims_company_list', $lims_company_list??[]);
            }
        });

    }
}
