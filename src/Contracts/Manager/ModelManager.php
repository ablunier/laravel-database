<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Manager;

interface ModelManager
{
    /**
     * Get Eloquent Model instance
     *
     * @param string $modelName
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelInstance($modelName);

    /**
     * Get Eloquent Model repository
     *
     * @param string $modelName
     *
     * @return \ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository
     */
    public function getRepository($modelName);

    /**
     * @param string $modelName
     *
     * @return \ANavallaSuiza\Laravel\Database\Contracts\Dbal\AbstractionLayer
     */
    public function getAbstractionLayer($modelName);
}
