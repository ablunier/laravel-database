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

    public function getModel()
    {
        return $this->model;
    }

    protected function getSchemaManager()
    {
        $connection = Schema::getConnection();

        return $connection->getDoctrineSchemaManager();
    }

    public function getTableColumns()
    {
        $sm = $this->getSchemaManager();

        $columns = $sm->listTableColumns($this->model->getTable());

        return $columns;
    }

    public function getModelAttributes()
    {
        $columns = $this->getTableColumns($this->model);

        $attributes = [];
        foreach ($columns as $fieldName => $field) {
            $attributes[] = $fieldName;
        }

        return $attributes;
    }

    public function getRelations()
    {

    }
}
