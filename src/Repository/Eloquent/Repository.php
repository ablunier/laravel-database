<?php

namespace Ablunier\Laravel\Database\Repository\Eloquent;

use Ablunier\Laravel\Database\Contracts\Repository\Criteria;
use Ablunier\Laravel\Database\Contracts\Repository\CriteriaPerformer;
use Ablunier\Laravel\Database\Contracts\Repository\Repository as RepositoryContract;
use Ablunier\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria;
use Ablunier\Laravel\Database\Repository\Exceptions\RepositoryException;
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

    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
        $this->criteria = new Collection();
    }

    /**
     * @return EloquentModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $with
     *
     * @return Collection
     */
    public function all(array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->get();

        $this->refresh();

        return $result;
    }

    /**
     * @param int $perPage
     *
     * @return mixed
     */
    public function paginate($perPage = 15, array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->paginate($perPage);

        $this->refresh();

        return $result;
    }

    /**
     * @param array $data
     *
     * @return EloquentModel
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
     *
     * @return EloquentModel
     */
    public function update(array $data, $id, $field = 'id')
    {
        $result = $this->model->where($field, '=', $id)->update($data);

        $this->refresh();

        if (!$result) {
            throw new RepositoryException('There was an error updating the model');
        }

        $model = $this->find($id);

        return $model;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $result = $this->model->destroy($id);

        $this->refresh();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id, array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->find($id);

        $this->refresh();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed|Exception
     */
    public function findOrFail($id, array $with = [])
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
     *
     * @return mixed
     */
    public function findBy($field, $value, array $with = [])
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
     *
     * @return mixed
     */
    public function findByOrFail($field, $value, array $with = [])
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
     *
     * @return mixed
     */
    public function findAllBy($field, $value, array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->where($field, '=', $value)->get();

        $this->refresh();

        return $result;
    }

    /**
     * @param array $with
     *
     * @return mixed
     */
    public function first(array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->first();

        $this->refresh();

        return $result;
    }

    /**
     * @param array $with
     *
     * @return mixed
     */
    public function firstOrFail(array $with = [])
    {
        $this->addWithCriteria($with);
        $this->applyCriteria();

        $result = $this->model->firstOrFail();

        $this->refresh();

        return $result;
    }

    /**
     * @param array $with
     *
     * @return void
     */
    protected function addWithCriteria(array $with = [])
    {
        if (count($with) > 0) {
            $this->pushCriteria(new WithCriteria($with));
        }
    }

    protected function refresh()
    {
        if (!$this->model instanceof EloquentModel) {
            $this->model = $this->model->getModel();
        }

        $this->model = $this->model->newInstance();
        $this->criteria = new Collection();
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);

        return $this;
    }

    /**
     * @param Criteria $criteria
     *
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
