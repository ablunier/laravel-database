<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Dbal;

interface AbstractionLayer
{

    public function getTableColumns();

    public function getModelAttributes();

    public function getRelations();
}
