<?php
namespace ANavallaSuiza\Laravel\Database\Repository\Eloquent;

use ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository as RepositoryContract;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\CriteriaPerformer;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\Criteria;
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
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $this->applyCriteria();

        return $this->model->get();
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 15)
    {
        $this->applyCriteria();

        return $this->model->paginate($perPage);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function update(array $data, $id, $field = "id")
    {
        return $this->model->where($field, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $this->applyCriteria();

        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return mixed|Exception
     */
    public function findOrFail($id)
    {
        $this->applyCriteria();

        return $this->model->findOrFail($id);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value)
    {
        $this->applyCriteria();

        return $this->model->where($field, '=', $value)->first();
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByOrFail($field, $value)
    {
        $this->applyCriteria();

        return $this->model->where($field, '=', $value)->firstOrFail();
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findAllBy($field, $value)
    {
        $this->applyCriteria();

        return $this->model->where($field, '=', $value)->get();
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
