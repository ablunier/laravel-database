<?php
namespace ANavallaSuiza\Laravel\Database\Manager\Eloquent;

use ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager as ModelManagerContract;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\HasCustomRepository;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class ModelManager implements ModelManagerContract
{
    /**
     * Get Eloquent Model instance
     *
     * @param string $modelName
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function instantiateModel($modelName)
    {
        $modelInstance = App::make($modelName);

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
            $repository = App::make($modelInstance->repository(), $args);

            if (! $repository instanceof Repository) {
                $message = "The [$modelName] custom repository must extend ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository.";

                throw new \Exception($message);
            }

            return $repository;
        } else {
            return App::make('ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository', $args);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAbstractionLayer($modelName)
    {

    }
}
