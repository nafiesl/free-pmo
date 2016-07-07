<?php

namespace App\Entities\Options;

use App\Entities\BaseRepository;
use App\Exceptions\OptionNotFoundException;
use App\Exceptions\OptionUpdateException;
use App\Exceptions\OptionDeleteException;

/**
* Options Repository Class
*/
class OptionsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    public function getAll($q = null)
    {
        return Option::all();
    }

    public function save($optionsData)
    {
        $options = $this->getAll();
        foreach ($optionsData as $key => $value) {
            $option = $options->where('key', $key)->first();
            $option->value = $value;
            $option->save();
        }

        return 'saved';
    }
}