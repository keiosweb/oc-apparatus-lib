<?php namespace Keios\Apparatus\Classes;

abstract class Repository
{

    /**
     * @var string|null
     */
    protected $model = null;


    public function all()
    {
        $model = $this->model;

        $collection = $model::all();

        return;
    }


}