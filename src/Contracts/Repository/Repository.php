<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Repository;

interface Repository
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage = 15);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed|Exception
     */
    public function findOrFail($id);

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findBy($field, $value);

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findByOrFail($field, $value);

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findAllBy($field, $value);
}
