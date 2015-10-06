<?php
namespace ANavallaSuiza\Laravel\Database\Dbal\Eloquent;

use ANavallaSuiza\Laravel\Database\Contracts\Dbal\AbstractionLayer as AbstractionLayerContract;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Schema;

class AbstractionLayer implements AbstractionLayerContract
{
    /**
     * @var EloquentModel
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    protected function getSchemaManager()
    {
        $connection = Schema::getConnection();

        return $connection->getDoctrineSchemaManager();
    }
}
