<?php

namespace App\Repositories\Tournament;
use App\Models\Tournament\Division as Model;
use App\Repositories\Tournament\Contracts\RepositoryInterface;

class DivisionRepository implements RepositoryInterface
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    public function all()
    {
        return Model::all();
    }

    public function truncate()
    {
        Model::truncate();
    }

    public function insert(array $arr)
    {
        Model::insert($arr);
    }
    
}