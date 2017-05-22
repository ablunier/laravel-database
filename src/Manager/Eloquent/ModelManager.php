<?php

namespace Ablunier\Laravel\Database\Manager\Eloquent;

use Ablunier\Laravel\Database\Contracts\Manager\ModelManager as ModelManagerContract;
use Ablunier\Laravel\Database\Contracts\Repository\HasCache;
use Ablunier\Laravel\Database\Contracts\Repository\HasCustomRepository;
use Ablunier\Laravel\Database\Repository\Eloquent\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class ModelManager implements ModelManagerContract
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get Eloquent Model instance.
     *
     * @param string $modelName
     *
     * @return EloquentModel
     */
    public function getModelInstance($modelName)
    {
        $modelInstance = new $modelName;

        if (!$modelInstance instanceof EloquentModel) {
            $message = "Target [$modelName] is not an Illuminate\Database\Eloquent\Model instance.";

            throw new \Exception($message);
        }

        return $modelInstance;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository($modelName)
    {
        $modelInstance = $this->getModelInstance($modelName);

        if ($modelInstance instanceof HasCustomRepository) {
            $repositoryClass = $modelInstance->repository();
            $repository = new $repositoryClass($modelInstance);

            if (!$repository instanceof Repository) {
                $message = "The [$modelName] custom repository must extend Ablunier\Laravel\Database\Repository\Eloquent\Repository.";

                throw new \Exception($message);
            }
        } else {
            $repository = new \Ablunier\Laravel\Database\Repository\Eloquent\Repository($modelInstance);
        }

        if ($modelInstance instanceof HasCache && $modelInstance->cache() === true) {
            return new \Ablunier\Laravel\Database\Repository\Eloquent\Cache($repository, $this->app['cache.store']);
        }

        return $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbstractionLayer($modelName)
    {
        $modelInstance = $this->getModelInstance($modelName);

        $args = ['model' => $modelInstance];

        $dbal = $this->app->make('Ablunier\Laravel\Database\Dbal\Eloquent\AbstractionLayer', $args);

        return $dbal;
    }
}
