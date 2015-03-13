<?php namespace Keios\Apparatus\Classes;

use Cms\Classes\Theme;
use Cms\Classes\Page;

class RouteResolver
{
    protected $theme;

    protected $pages;

    protected $componentPageCache = [];

    public function __construct()
    {
        $this->theme = Theme::getEditTheme();
        $this->pages = Page::listInTheme($this->theme, true);
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
        $url = $this->resolveRouteTo($component);

        $properties = $page->getComponentProperties($component);
        $parameterValue = $properties[$parameter];

        if (strpos($url, ':') !== false) {
            return preg_replace('/\\:('.$parameterValue.')\\??/', $value, $url, -1);
        } else {
            return null;
        }
    }
}