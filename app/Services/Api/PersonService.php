<?php

namespace App\Services\Api;

use App\WebModel\Request\PersonRequest;

interface PersonService
{
    public function store($orgId, PersonRequest $request);
    public function findById($orgId, $id);
    public function update($orgId, $id, PersonRequest $request);
    public function delete($orgId, $id);
}
