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
    public function all(array $with = []);

    /**
     * @param $perPage
     *
     * @return mixed
     */
    public function paginate($perPage = 15, array $with = []);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     * @param string $field
     *
     * @return mixed
     */
    public function update(array $data, $id, $field = 'id');

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id, array $with = []);

    /**
     * @param $id
     *
     * @return mixed|Exception
     */
    public function findOrFail($id, array $with = []);

    /**
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    public function findBy($field, $value, array $with = []);

    /**
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    public function findByOrFail($field, $value, array $with = []);

    /**
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    public function findAllBy($field, $value, array $with = []);
}
