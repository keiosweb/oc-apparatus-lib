<?php namespace Keios\Apparatus\Models;

use October\Rain\Database\Model;

/**
 * Settings Model
 */
class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];
    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * A unique code of settings
     */
    public $settingsCode = 'keios::apparatus.settings';

    /**
     * Reference to field configuration
     */
    public $settingsFields = 'fields.yaml';

    public function listAnimations()
    {
        return [
            'animated bounce' => 'bounce',
            'animated flash' => 'flash',
            'animated pulse' => 'pulse',
            'animated rubberBand' => 'rubberBand',
            'animated shake' => 'shake',
            'animated swing' => 'swing',
            'animated tada' => 'tada',
            'animated wobble' => 'wobble',
            'animated bounceIn' => 'bounceIn',
            'animated bounceInDown' => 'bounceInDown',
            'animated bounceInLeft' => 'bounceInLeft',
            'animated bounceInRight' => 'bounceInRight',
            'animated bounceInUp' => 'bounceInUp',
            'animated bounceOut' => 'bounceOut',
            'animated bounceOutDown' => 'bounceOutDown',
            'animated bounceOutLeft' => 'bounceOutLeft',
            'animated bounceOutRight' => 'bounceOutRight',
            'animated bounceOutUp' => 'bounceOutUp',
            'animated fadeIn' => 'fadeIn',
            'animated fadeInDown' => 'fadeInDown',
            'animated fadeInDownBig' => 'fadeInDownBig',
            'animated fadeInLeft' => 'fadeInLeft',
            'animated fadeInLeftBig' => 'fadeInLeftBig',
            'animated fadeInRight' => 'fadeInRight',
            'animated fadeInRightBig' => 'fadeInRightBig',
            'animated fadeInUp' => 'fadeInUp',
            'animated fadeInUpBig' => 'fadeInUpBig',
            'animated fadeOut' => 'fadeOut',
            'animated fadeOutDown' => 'fadeOutDown',
            'animated fadeOutDownBig' => 'fadeOutDownBig',
            'animated fadeOutLeft' => 'fadeOutLeft',
            'animated fadeOutLeftBig' => 'fadeOutLeftBig',
            'animated fadeOutRight' => 'fadeOutRight',
            'animated fadeOutRightBig' => 'fadeOutRightBig',
            'animated fadeOutUp' => 'fadeOutUp',
            'animated fadeOutUpBig' => 'fadeOutUpBig',
            'animated flipInX' => 'flipInX',
            'animated flipInY' => 'flipInY',
            'animated flipOutX' => 'flipOutX',
            'animated flipOutY' => 'flipOutY',
            'animated lightSpeedIn' => 'lightSpeedIn',
            'animated lightSpeedOut' => 'lightSpeedOut',
            'animated rotateIn' => 'rotateIn',
            'animated rotateInDownLeft' => 'rotateInDownLeft',
            'animated rotateInDownRight' => 'rotateInDownRight',
            'animated rotateInUpLeft' => 'rotateInUpLeft',
            'animated rotateInUpRight' => 'rotateInUpRight',
            'animated rotateOut' => 'rotateOut',
            'animated rotateOutDownLeft' => 'rotateOutDownLeft',
            'animated rotateOutDownRight' => 'rotateOutDownRight',
            'animated rotateOutUpLeft' => 'rotateOutUpLeft',
            'animated rotateOutUpRight' => 'rotateOutUpRight',
            'animated hinge' => 'hinge',
            'animated rollIn' => 'rollIn',
            'animated rollOut' => 'rollOut',
            'animated zoomIn' => 'zoomIn',
            'animated zoomInDown' => 'zoomInDown',
            'animated zoomInLeft' => 'zoomInLeft',
            'animated zoomInRight' => 'zoomInRight',
            'animated zoomInUp' => 'zoomInUp',
            'animated zoomOut' => 'zoomOut',
            'animated zoomOutDown' => 'zoomOutDown',
            'animated zoomOutLeft' => 'zoomOutLeft',
            'animated zoomOutRight' => 'zoomOutRight',
            'animated zoomOutUp' => 'zoomOutUp',
            'animated slideInDown' => 'slideInDown',
            'animated slideInLeft' => 'slideInLeft',
            'animated slideInRight' => 'slideInRight',
            'animated slideInUp' => 'slideInUp',
            'animated slideOutDown' => 'slideOutDown',
            'animated slideOutLeft' => 'slideOutLeft',
            'animated slideOutRight' => 'slideOutRight',
            'animated slideOutUp' => 'slideOutUp',
        ];
    }

    public function getOpenAnimationOptions()
    {
        return $this->listAnimations();
    }

    public function getCloseAnimationOptions()
    {
        return $this->listAnimations();
    }

    public function getLayoutOptions()
    {
        return [
            'top' => 'top',
            'topLeft' => 'topLeft',
            'topCenter' => 'topCenter',
            'topRight' => 'topRight',
            'center' => 'center',
            'centerLeft' => 'centerLeft',
            'centerRight' => 'centerRight',
            'bottom' => 'bottom',
            'bottomLeft' => 'bottomLeft',
            'bottomCenter' => 'bottomCenter',
            'bottomRight' => 'bottomRight',
        ];
    }
}