<?php
namespace ANavallaSuiza\Laravel\Database\Repository\Eloquent;

use ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository as RepositoryContract;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\CriteriaPerformer;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\Criteria;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

class Repository implements RepositoryContract, CriteriaPerformer
{
    /**
     * @var EloquentModel
     */
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @param App $app
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
        $this->criteria = new Collection;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function all(array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->get();

        $this->refresh();

        return $result;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 15, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->paginate($perPage);

        $this->refresh();

        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $result = $this->model->create($data);

        $this->refresh();

        return $result;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function update(array $data, $id, $field = "id")
    {
        $result = $this->model->where($field, '=', $id)->update($data);

        $this->refresh();

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->model->destroy($id);

        $this->refresh();

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->find($id);

        $this->refresh();

        return $result;
    }

    /**
     * @param $id
     * @return mixed|Exception
     */
    public function findOrFail($id, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->findOrFail($id);

        $this->refresh();

        return $result;
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->where($field, '=', $value)->first();

        $this->refresh();

        return $result;
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByOrFail($field, $value, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->where($field, '=', $value)->firstOrFail();

        $this->refresh();

        return $result;
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findAllBy($field, $value, array $with = array())
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->where($field, '=', $value)->get();

        $this->refresh();

        return $result;
    }

    /**
     * @param array $with
     * @return void
     */
    protected function addWithCriteria(array $with = array())
    {
        if (count($with) > 0) {
            $this->pushCriteria(new WithCriteria($with));
        }
    }

    /**
     *
     */
    protected function refresh()
    {
        if (! $this->model instanceof EloquentModel) {
            $this->model = $this->model->getModel();
        }

        $this->model = $this->model->newInstance();
        $this->criteria = new Collection;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);

        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            $this->model = $criteria->apply($this->model, $this);
        }

        return $this;
    }
}
