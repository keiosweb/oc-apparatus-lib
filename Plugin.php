<?php namespace Keios\Apparatus;

use Cms\Classes\ComponentBase;
use Illuminate\Foundation\AliasLoader;
use Keios\Apparatus\Classes\BackendInjector;
use Keios\Apparatus\Classes\DependencyInjector;
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
            'name'        => 'Apparatus',
            'description' => 'keios.apparatus::lang.labels.pluginName',
            'author'      => 'Keios',
            'icon'        => 'icon-cogs'
        ];
    }

    public function registerComponents()
    {
        return [
            'Keios\Apparatus\Components\Messaging' => 'apparatusFlashMessages'
        ];
    }

    public function registerSettings()
    {
        return [
            'messaging' => [
                'label'       => 'keios.apparatus::lang.settings.messaging-label',
                'description' => 'keios.apparatus::lang.settings.messaging-description',
                'category'    => 'Apparatus',
                'icon'        => 'icon-globe',
                'class'       => '\Keios\Apparatus\Models\Settings',
                'order'       => 500,
                'keywords'    => 'messages flash notifications'
            ]
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

        $this->app->singleton(
            'apparatus.backend.injector',
            function () {
                return new BackendInjector();
            }
        );

        $this->app->singleton('apparatus.dependencyInjector', function () {
            return new DependencyInjector($this->app);
        });

        $this->app->make('events')->listen('cms.page.initComponents', function ($controller) {
            foreach ($controller->vars as $variable) {
                if ($variable instanceof ComponentBase) {
                    $this->app->make('apparatus.dependencyInjector')->injectDependencies($variable);
                }
            }
        });

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Resolver', 'Keios\Apparatus\Facades\Resolver');

        $injector = $this->app->make('apparatus.backend.injector');
        $injector->addCss('/plugins/keios/apparatus/assets/css/animate.css');
    }

}
