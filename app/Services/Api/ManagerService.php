<?php

namespace App\Services\Api;

use App\WebModel\Request\ManagerRequest;

interface ManagerService
{
    public function getAll();
    public function store(ManagerRequest $request);
    public function findById($id);
    public function update(ManagerRequest $request, $id);
    public function delete($id);
}
