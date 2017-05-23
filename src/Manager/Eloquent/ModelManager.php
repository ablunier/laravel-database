<?php

namespace Ablunier\Laravel\Database\Manager\Eloquent;

use Ablunier\Laravel\Database\Contracts\Manager\ModelManager as ModelManagerContract;
use Ablunier\Laravel\Database\Contracts\Repository\HasCache;
use Ablunier\Laravel\Database\Contracts\Repository\HasCustomRepository;
use Ablunier\Laravel\Database\Dbal\Eloquent\AbstractionLayer;
use Ablunier\Laravel\Database\Repository\Eloquent\Cache;
use Ablunier\Laravel\Database\Repository\Eloquent\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Manager\Exceptions\InvalidModelException;
use Manager\Exceptions\InvalidRepositoryException;

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
     * @throws \Exception
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelInstance($modelName)
    {
        $modelInstance = new $modelName();

        if (!$modelInstance instanceof EloquentModel) {
            $message = "Target [$modelName] is not an Illuminate\Database\Eloquent\Model instance.";

            throw new InvalidModelException($message);
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

                throw new InvalidRepositoryException($message);
            }
        } else {
            $repository = new Repository($modelInstance);
        }

        if ($modelInstance instanceof HasCache && $modelInstance->cache() === true) {
            return new Cache($repository, $this->app['cache.store']);
        }

        return $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbstractionLayer($modelName)
    {
        $modelInstance = $this->getModelInstance($modelName);

        $dbal = new AbstractionLayer($modelInstance);

        return $dbal;
    }
}
