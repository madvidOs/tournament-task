<?php

namespace App\Src\Tournament\Repositories;

use App\Src\Tournament\Models\PlayoffParticipant as Model;
use App\Src\Tournament\Repositories\Contracts\RepositoryInterface;

class PlayoffParticipantRepository implements RepositoryInterface
{
    /**
     * Get class of used model
     * 
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get all rows of table
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Model::all();
    }

    /**
     * Truncate table
     * 
     * @return void
     */
    public function truncate()
    {
        Model::truncate();
    }

    /**
     * Insert list of data
     * 
     * @param array $arr data
     * 
     * @return void
     */
    public function insert(array $arr)
    {
        Model::insert($arr);
    }
}
