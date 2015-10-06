<?php
namespace ANavallaSuiza\Laravel\Database\Manager\Eloquent;

use ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager as ModelManagerContract;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\HasCustomRepository;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\HasCache;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Contracts\Foundation\Application;

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
     * Get Eloquent Model instance
     *
     * @param string $modelName
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function instantiateModel($modelName)
    {
        $modelInstance = $this->app->make($modelName);

        if (! $modelInstance instanceof EloquentModel) {
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
        $modelInstance = $this->instantiateModel($modelName);

        $args = ['model' => $modelInstance];

        if ($modelInstance instanceof HasCustomRepository) {
            $repository = $this->app->make($modelInstance->repository(), $args);

            if (! $repository instanceof Repository) {
                $message = "The [$modelName] custom repository must extend ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository.";

                throw new \Exception($message);
            }
        } else {
            $repository = $this->app->make('ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository', $args);
        }

        if ($modelInstance instanceof HasCache && $modelInstance->cache() === true) {
            return $this->app->make('ANavallaSuiza\Laravel\Database\Repository\Eloquent\Cache', [
                'repository' => $repository,
                'cache'      => $this->app['cache.store']
            ]);
        }

        return $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbstractionLayer($modelName)
    {
        $modelInstance = $this->instantiateModel($modelName);

        $args = ['model' => $modelInstance];

        $dbal = $this->app->make('ANavallaSuiza\Laravel\Database\Dbal\Eloquent\AbstractionLayer', $args);

        return $dbal;
    }
}
