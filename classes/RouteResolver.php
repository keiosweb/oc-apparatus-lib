<?php namespace Keios\Apparatus\Classes;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Contracts\Config\Repository;
use Cms\Classes\Theme;
use Cms\Classes\Page;


/**
 * Class RouteResolver
 *
 * @package Keios\Apparatus\Classes
 */
class RouteResolver
{
    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var array
     */
    protected $pages;

    /**
     * @var Log
     */
    protected $log;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $componentPageCache = [];

    /**
     * RouteResolver constructor.
     *
     * @param Repository $config
     * @param Log        $log
     */
    public function __construct(Repository $config, Log $log)
    {
        $this->theme = Theme::getActiveTheme();
        $this->pages = Page::listInTheme($this->theme, true);
        $this->log = $log;
        $this->config = $config;
    }

    /**
     * @param $component
     *
     * @return Page|null
     * @throws \Exception
     */
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

    /**
     * @param $component
     *
     * @return array|Page|null
     */
    public function resolveRouteTo($component)
    {
        if ($page = $this->getPageWithComponent($component)) {
            return $page->settings['url'];
        } else {
            return $page;
        }
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public function stripUrlParameters($url)
    {
        if (strpos($url, '/:') !== false) {
            $parts = explode('/:', $url);

            return $parts[0];
        } else {
            return $url;
        }
    }

    /**
     * @param $component
     *
     * @return mixed|string
     */
    public function resolveRouteWithoutParamsTo($component)
    {
        $page = $this->getPageWithComponent($component);

        /*
         * In production, on broken component links, return /error for graceful error handling
         */
        if (!$page) {
            return '/error';
        }

        $url = $this->resolveRouteTo($component);

        return $this->stripUrlParameters($url);
    }


    /**
     * @param $component
     * @param $parameter
     * @param $value
     *
     * @return mixed|null|string
     * @throws \Exception
     */
    public function resolveParameterizedRouteTo($component, $parameter, $value)
    {
        $page = $this->getPageWithComponent($component);

        /*
         * In production, on broken component links, return /error for graceful error handling
         */
        if (!$page) {
            return '/error';
        }

        $url = $this->resolveRouteTo($component);

        $properties = $page->getComponentProperties($component);

        /*
         * In production, on broken component links, return /error for graceful error handling
         */
        if (!array_key_exists($parameter, $properties)) {
            $this->parameterNotFound($parameter, $component);

            return '/error';
        }

        $parameterValue = $properties[$parameter];

        /*
         * Strip external parameter tags, ie {{ :code }} -> code
         */
        if (strpos($parameterValue, '{') !== false) {
            $parameterValue = trim(str_replace('{', '', str_replace('}', '', str_replace(':', '', $parameterValue))));

            // also: :code -> code
        } elseif (strpos($parameterValue, ':') !== false) {
            $parameterValue = trim(str_replace(':', '', $parameterValue));
        }

        if (strpos($url, ':') !== false) {
            return preg_replace('/\\:('.$parameterValue.')\\??/', $value, $url, -1);
        } else {
            return null;
        }
    }

    /**
     * @param $component
     *
     * @throws \Exception
     */
    protected function componentNotFound($component)
    {
        if ($this->config->get('app.debug')) {
            throw new \Exception(sprintf(trans('keios.apparatus::lang.errors.pageWithComponentNotFound'), $component));
        } else {
            $this->log->error(sprintf(trans('keios.apparatus::lang.errors.pageWithComponentNotFound'), $component));
        }
    }

    /**
     * @param $parameter
     * @param $component
     *
     * @throws \Exception
     */
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