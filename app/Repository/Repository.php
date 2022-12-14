<?php

namespace App\Repository;

abstract class Repository
{
    abstract public function model();

    protected $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    public function all()
    {
        return $this->model->all();
    }

}
