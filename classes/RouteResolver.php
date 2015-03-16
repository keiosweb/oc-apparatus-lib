<?php namespace Keios\Apparatus\Classes;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Contracts\Config\Repository;
use Cms\Classes\Theme;
use Cms\Classes\Page;


class RouteResolver
{
    protected $theme;

    protected $pages;

    protected $log;

    protected $config;

    protected $componentPageCache = [];

    public function __construct(Repository $config, Log $log)
    {
        $this->theme = Theme::getEditTheme();
        $this->pages = Page::listInTheme($this->theme, true);
        $this->log = $log;
        $this->config = $config;
    }

    public function getPageWithComponent($component)
    {
        if (isset($this->componentPageCache[$component])) {
            return $this->componentPageCache[$component];
        }

        /**
         * @var \Cms\Classes\Page $page
         */
        foreach ($this->pages as $page) {
            if ($page->hasComponent($component)) {
                $this->componentPageCache[$component] = $page;

                return $page;
            }
        }

        $this->componentNotFound($component);

        return null;
    }

    public function resolveRouteTo($component)
    {
        if ($page = $this->getPageWithComponent($component)) {
            return $page->settings['url'];
        } else {
            return $page;
        }
    }

    public function resolveParameterizedRouteTo($component, $parameter, $value)
    {
        $page = $this->getPageWithComponent($component);

        if (!$page) {
            return '/error';
        }

        $url = $this->resolveRouteTo($component);

        $properties = $page->getComponentProperties($component);

        if (!array_key_exists($parameter, $properties)) {
            $this->parameterNotFound($parameter, $component);

            return '/error';
        }

        $parameterValue = $properties[$parameter];

        if (strpos($parameterValue, '{') !== false) {
            $parameterValue = trim(str_replace('{', '', str_replace('}', '', str_replace(':', '', $parameterValue))));
        } elseif (strpos($parameterValue, ':') !== false) {
            $parameterValue = trim(str_replace(':', '', $parameterValue));
        }

        if (strpos($url, ':') !== false) {
            return preg_replace('/\\:('.$parameterValue.')\\??/', $value, $url, -1);
        } else {
            return null;
        }
    }

    protected function componentNotFound($component)
    {
        if ($this->config->get('app.debug')) {
            throw new \Exception(sprintf(trans('keios.apparatus::lang.errors.pageWithComponentNotFound'), $component));
        } else {
            $this->log->error(sprintf(trans('keios.apparatus::lang.errors.pageWithComponentNotFound'), $component));
        }
    }

    protected function parameterNotFound($parameter, $component)
    {
        if ($this->config->get('app.debug')) {
            throw new \Exception(
                sprintf(trans('keios.apparatus::lang.errors.parameterNotFound'), $parameter, $component)
            );
        } else {
            $this->log->error(
                sprintf(trans('keios.apparatus::lang.errors.parameterNotFound'), $parameter, $component)
            );
        }
    }
}