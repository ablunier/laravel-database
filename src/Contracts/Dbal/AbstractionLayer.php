<?php
namespace Ablunier\Laravel\Database\Contracts\Dbal;

interface AbstractionLayer
{
    /**
     * @return mixed
     */
    public function getModel();

    public function getTableColumns();

    public function getTableColumn($name);

    public function getModelAttributes();

    public function getTableForeignKeys();
}
