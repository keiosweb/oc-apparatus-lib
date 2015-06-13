<?php

Route::get(
    '/storage/app/uploads/protected/{slug}',
    function ($slug) {
        $path = storage_path().'/app/uploads/protected/'.$slug;

        if (!\Backend\Facades\BackendAuth::check()) {
            return Redirect::to('/404');
        }

        if (!File::exists($path)) {
            return Redirect::to('/404');
        }

        $segmentizedUrl = \October\Rain\Router\Helper::segmentizeUrl(Request::url());
        $diskName = array_pop($segmentizedUrl);

        if (!$file = \System\Models\File::where('disk_name', $diskName)->first()) {
            return Redirect::to('/404');
        };

        return $file->output('attachment');
    }
)->where('slug', '(.*)?');

Route::post('/_translapi', 'Keios\Apparatus\Classes\TranslApiController@getTranslations');