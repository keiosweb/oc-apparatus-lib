<?php namespace Keios\Apparatus;

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
    }

}
