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

    public function getTableColumn($name)
    {
        $columns = $this->getTableColumns();

        if (!array_key_exists($name, $columns)) {
            throw new \Exception("Column ".$name." not found on ".$this->model->getTable());
        }

        return $columns[$name];
    }

    public function getModelAttributes()
    {
        $columns = $this->getTableColumns();

        $attributes = [];
        foreach ($columns as $fieldName => $field) {
            $attributes[] = $fieldName;
        }

        return $attributes;
    }

    public function getTableForeignKeys()
    {
        $sm = $this->getSchemaManager();

        $foreignKeys = $sm->listTableForeignKeys($this->model->getTable());

        return $foreignKeys;
    }
}
