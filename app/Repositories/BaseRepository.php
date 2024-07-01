<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {

    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel(): string;

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(string $id)
    {
        return $this->model->find($id)->delete();
    }

    public function find(string $id)
    {
        return $this->model->find($id);
    }

    public function findBy(string $field, string $value)
    {
        return $this->model->where($field, $value)->get();
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

}