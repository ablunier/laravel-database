<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Dbal;

interface AbstractionLayer
{
    /**
     * @return mixed
     */
    public function getModel();

    public function getTableColumns();

    public function getModelAttributes();

    public function getTableForeignKeys();
}
