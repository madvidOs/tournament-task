<?php

namespace App\Src\Tournament\Repositories;
use App\Src\Tournament\Models\DivisionTeam as Model;
use App\Src\Tournament\Repositories\Contracts\RepositoryInterface;

class DivisionTeamRepository implements RepositoryInterface
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
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