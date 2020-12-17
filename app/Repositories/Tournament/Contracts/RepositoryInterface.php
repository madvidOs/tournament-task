<?php
namespace App\Repositories\Tournament\Contracts;


interface RepositoryInterface
{
    public function getModelClass();
    public function all();
    public static function truncate();
    public static function insert(array $arr);
}