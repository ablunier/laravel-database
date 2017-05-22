<?php
namespace Ablunier\Laravel\Database\Contracts\Repository;

interface Repository
{
    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @return mixed
     */
    public function all(array $with = array());

    /**
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage = 15, array $with = array());

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function update(array $data, $id, $field = "id");

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id, array $with = array());

    /**
     * @param $id
     * @return mixed|Exception
     */
    public function findOrFail($id, array $with = array());

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findBy($field, $value, array $with = array());

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findByOrFail($field, $value, array $with = array());

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findAllBy($field, $value, array $with = array());
}
