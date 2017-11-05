<?php

namespace App\Entities;

use App\Exceptions\EntityNotFoundException;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Repository Class
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class EloquentRepository
{
    protected $_paginate = 25;
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getAll($q)
    {
        return $this->model->latest()
            ->where('name', 'like', '%'.$q.'%')
            ->paginate($this->_paginate);
    }

    public function getById($id)
    {
        return $this->getBy($this->model->getKeyName(), $id);
    }

    public function getBy($column, $value)
    {
        $model = $this->model->newQuery()->where($column, $value)->get();
        if ($model->count() > 1) {
            return $model;
        }

        return $model->first();
    }

    public function requireById($id)
    {
        $model = $this->getById($id);
        if (!$model) {
            throw new EntityNotFoundException($id, $this->model->getTable());
        }

        return $model;
    }

    public function getNewInstance($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    public function create($data)
    {
        if ($data instanceof Model) {
            return $this->storeEloquentModel($data);
        } else {
            foreach ($data as $key => $value) {
                if ($data[$key] == '') {
                    $data[$key] = null;
                }

            }
            return $this->storeArray($data);
        }
    }

    public function update($data = [], $modelId)
    {
        foreach ($data as $key => $value) {
            if (!$data[$key]) {
                $data[$key] = null;
            }

        }

        $model = $this->requireById($modelId);
        $model->update($data);
        return $model;
    }

    public function delete($modelId)
    {
        $model = $this->requireById($modelId);
        return $model->delete();
    }

    protected function storeEloquentModel(Model $model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNewInstance($data);
        $this->storeEloquentModel($model);
        return $model;
    }
}
