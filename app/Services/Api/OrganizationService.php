<?php

namespace App\Services\Api;


use App\WebModel\Request\AssignManagerRequest;
use App\WebModel\Request\OrganizationRequest;

interface OrganizationService
{
    public function getAll();
    public function store(OrganizationRequest $request);
    public function findById($id);
    public function update(OrganizationRequest $request, $id);
    public function delete($id);
    public function storeManager($id, AssignManagerRequest $request);
}
