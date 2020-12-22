<?php
namespace App\Repositories\Tournament\Contracts;


interface RepositoryInterface
{
    public function getModelClass();
    public function all();
    public function truncate();
    public function insert(array $arr);
}