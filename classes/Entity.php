<?php namespace Keios\Apparatus\Classes;

use October\Rain\Database\Model;

abstract class Entity
{
    protected $model;

    protected function setModelInstance(Model $model)
    {
        $this->model = new Model();
    }

    protected function getModelInstance()
    {
        return $this->model;
    }
}