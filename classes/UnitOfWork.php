<?php namespace Keios\Apparatus\Classes;

use Illuminate\Database\DatabaseManager;

class UnitOfWork
{

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * @var array
     */
    protected $entities = [];

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function add(Entity $entity)
    {
        $this->entities[] = $entity;
    }

    public function flush()
    {
        $this->db->transaction(function () {
            foreach ($this->entities as $entity) {
                $modelClass = $entity->getModelClass();

                $saveMethod = new \ReflectionMethod($modelClass, 'getModelInstance');
                $saveMethod->setAccessible(true);

                $modelInstance = $saveMethod->invoke($entity);

                $modelInstance->save();
            }
        });
    }
}