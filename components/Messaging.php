<?php namespace Keios\Apparatus\Components;

use Cms\Classes\ComponentBase;
use Keios\Apparatus\Models\Settings;

class Messaging extends ComponentBase
{
    public $layout;
    public $openAnimation;
    public $closeAnimation;
    public $theme;
    public $template;
    public $timeout;
    public $dismissQueue;
    public $force;
    public $modal;
    public $maxVisible;

    public function componentDetails()
    {
        return [
            'name' => 'Apparatus Messaging',
            'description' => 'Provides Apparatus Messaging functionality'
        ];
    }

    public function onRun()
    {
        $this->addCss('/plugins/keios/apparatus/assets/css/animate.css');
        $this->addJs('/plugins/keios/apparatus/assets/js/noty/packaged/jquery.noty.packaged.min.js');
        $this->addJs('/plugins/keios/apparatus/assets/js/framework.messaging.js');

        $settings = Settings::instance()->value;

        if (!is_array($settings)) {
            return;
        }

        $this->layout = $settings['layout'];
        $this->openAnimation = $settings['openAnimation'];
        $this->closeAnimation = $settings['closeAnimation'];
        $this->theme = $settings['theme'];
        $this->template = $settings['template'];
        $this->timeout = $settings['timeout'];
        $this->dismissQueue = $settings['dismissQueue'];
        $this->force = $settings['force'];
        $this->modal = $settings['modal'];
        $this->maxVisible = $settings['maxVisible'];
    }

}