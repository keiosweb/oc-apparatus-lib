<?php namespace Keios\Apparatus;

use Illuminate\Foundation\AliasLoader;
use Keios\Apparatus\Classes\RouteResolver;
use System\Classes\PluginBase;

/**
 * Apparatus Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Apparatus',
            'description' => 'keios.apparatus::lang.labels.pluginName',
            'author' => 'Keios',
            'icon' => 'icon-cogs'
        ];
    }

    public function boot()
    {
        $this->app->register('Keios\LaravelApparatus\LaravelApparatusServiceProvider');
        $this->app->singleton(
            'apparatus.route.resolver',
            function () {
                return new RouteResolver($this->app['config'], $this->app->make('log'));
            }
        );

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Resolver', 'Keios\Apparatus\Facades\Resolver');
    }

}
