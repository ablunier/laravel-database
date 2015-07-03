<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Manager;

interface ModelManager
{
    /**
     * Get Eloquent Model repository
     *
     * @param string $modelName
     *
     * @return ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository
     */
    public function getRepository($modelName);

    /**
     *
     */
    public function getAbstractionLayer($modelName);
}
