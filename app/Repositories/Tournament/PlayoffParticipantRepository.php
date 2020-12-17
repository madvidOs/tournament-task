<?php

namespace App\Repositories\Tournament;
use App\Models\Tournament\PlayoffParticipant as Model;
use App\Repositories\Tournament\Contracts\RepositoryInterface;

class PlayoffParticipantRepository implements RepositoryInterface
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

    public static function truncate()
    {
        Model::truncate();
    }

    public static function insert(array $arr)
    {
        Model::insert($arr);
    }
    
}