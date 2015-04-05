<?php namespace Keios\Apparatus\Classes;

use Illuminate\Contracts\Container\Container;
use Keios\Apparatus\Contracts\NeedsDependencies;

class DependencyInjector
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function injectDependencies($object)
    {
        if (!is_object($object)) {
            return;
        }

        if (!$object instanceof NeedsDependencies) {
            return;
        }

        $methods = get_class_methods($object);

        foreach ($methods as $method) {
            if (strpos($method, 'inject') === 0) {
                $this->container->call([$object, $method]);
            }
        }
    }

}