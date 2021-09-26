<?php

namespace App\Entities;

use App\Exceptions\EntityNotFoundException;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class EloquentRepository
{
    /**
     * Default paginated items on each page.
     *
     * @var int
     */
    protected $_paginate = 25;

    /**
     * Corresponding model of repository.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create repository instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Set model of repository.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records filtered by $q (search query).
     *
     * @param  string  $q
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($q)
    {
        return $this->model->latest()
            ->where('name', 'like', '%'.$q.'%')
            ->paginate($this->_paginate);
    }

    /**
     * Get model record by id.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this->getBy($this->model->getKeyName(), $id);
    }

    /**
     * Get model record by column and value.
     *
     * @param  string  $column
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getBy($column, $value)
    {
        $model = $this->model->newQuery()->where($column, $value)->get();
        if ($model->count() > 1) {
            return $model;
        }

        return $model->first();
    }

    /**
     * Get model record by Id and throws exception if not found.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function requireById($id)
    {
        $model = $this->getById($id);
        if (!$model) {
            throw new EntityNotFoundException($id, $this->model->getTable());
        }

        return $model;
    }

    /**
     * Create new instance of model with given attributes.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getNewInstance($attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Create new record on database based on given data attributes.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
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

    /**
     * Update $data attributes on database based on given $modelId.
     *
     * @param  array  $data
     * @param  int  $modelId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($data, $modelId)
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

    /**
     * Delete record based on given id.
     *
     * @param  int  $modelId
     * @return bool
     */
    public function delete($modelId)
    {
        $model = $this->requireById($modelId);

        return $model->delete();
    }

    /**
     * Save instance of eloquent model data to database.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    protected function storeEloquentModel(Model $model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    /**
     * Store instance of model to database with given data.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function storeArray($data)
    {
        $model = $this->getNewInstance($data);
        $this->storeEloquentModel($model);

        return $model;
    }
}
