<?php

namespace App\Src\Tournament\Repositories;

use App\Src\Tournament\Models\Division as Model;
use App\Src\Tournament\Repositories\Contracts\RepositoryInterface;

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