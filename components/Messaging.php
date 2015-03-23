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

        $this->layout = Settings::instance()->get('layout');
        $this->openAnimation = Settings::instance()->get('openAnimation');
        $this->closeAnimation = Settings::instance()->get('closeAnimation');
        $this->theme = Settings::instance()->get('theme');
        $this->template = Settings::instance()->get('template');
        $this->timeout = Settings::instance()->get('timeout');
        $this->dismissQueue = Settings::instance()->get('dismissQueue');
        $this->force = Settings::instance()->get('force');
        $this->modal = Settings::instance()->get('modal');
        $this->maxVisible = Settings::instance()->get('maxVisible');
    }

}