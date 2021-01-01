<?php

namespace App\Src\Tournament\Repositories\Contracts;


interface RepositoryInterface
{
    /**
     * Get class of used model
     * 
     * @return string
     */
    public function getModelClass();
    
    /**
     * Get all rows of table
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Truncate table
     * 
     * @return void
     */
    public function truncate();

    /**
     * Insert list of data
     * 
     * @param array $arr data
     * 
     * @return void
     */
    public function insert(array $arr);
}
