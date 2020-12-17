<?php

namespace App\Repositories\Tournament;
use App\Models\Tournament\PlayoffWinner as Model;
use App\Repositories\Tournament\Contracts\RepositoryInterface;

class PlayoffWinnerRepository implements RepositoryInterface
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