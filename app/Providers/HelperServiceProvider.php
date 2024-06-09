<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * The helper mappings for the application.
     *
     * @var array
     */
    protected $helpers = [
        'ApplicationHelper' => 'App\Helpers\ApplicationHelper::getCount',
    ];

    /**
     * Bootstrap the application helpers.
     *
     * @return void
     */
    public function boot()
    {
//        foreach ($this->helpers as $alias => $method) {
//            if (!function_exists($alias)) {
////                eval("function {$alias}(...\$args) { return {$method}(...\$args); }");
//            }
//        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
