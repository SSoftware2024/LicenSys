<?php

namespace App\Classes\Abstract;

abstract class CRUD
{
    protected abstract function getModel();
    public abstract function read();
    public function create(array $data):mixed{
        $model = $this->getModel();
        return $model::create($data);
    }
    public function update(int $id, array $data):int{
        $model = $this->getModel();
        return $model::where('id', $id)->update($data);
    }
    public function delete(int $id):int{
        $model = $this->getModel();
        return $model::where('id', $id)->delete();
    }
}
