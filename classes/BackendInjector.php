<?php namespace Keios\Apparatus\Classes;

use Backend\Classes\Controller;

class BackendInjector
{
    protected $useBackendJSInjector = true;

    protected $jsAssets = [];
    protected $cssAssets = [];
    protected $ajaxHandlers = [];

    public function __construct()
    {
        Controller::extend(
            function (Controller $controller) {

                foreach ($this->jsAssets as $asset) {

                    if (is_array($asset['attributes'])) {
                        $asset['attributes']['build'] = 'apparatus-injected';
                    }

                    $controller->addJs($asset['path'], $asset['attributes']);
                }

                foreach ($this->cssAssets as $asset) {

                    if (is_array($asset['attributes'])) {
                        $asset['attributes']['build'] = 'apparatus-injected';
                    }

                    $controller->addCss($asset['path'], $asset['attributes']);
                }

                foreach ($this->ajaxHandlers as $handler) {
                    $controller->addDynamicMethod($handler['name'], $handler['function'], $handler['extension']);
                };

                if ($this->useBackendJSInjector) {
                    $controller->addJs('/plugins/keios/apparatus/assets/js/framework.validation.js', 'apparatus');
                }
            }
        );
    }

    public function addJs($path, $attributes = [])
    {
        $this->jsAssets[] = ['path' => $path, 'attributes' => $attributes];
    }

    public function addCss($path, $attributes = [])
    {
        $this->cssAssets[] = ['path' => $path, 'attributes' => $attributes];
    }

    public function addAjaxHandler($name, callable $handler, $extension = null)
    {
        $this->ajaxHandlers[] = ['name' => $name, 'function' => $handler, 'extension' => $extension];
    }
}