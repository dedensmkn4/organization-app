<?php

namespace App\Services\Impl;

use App\Constant\MessageResponse;
use App\Constant\TableName;
use App\Repositories\ManagerRepository;
use App\Repositories\OrganizationRepository;
use App\Services\Api\OrganizationService;
use App\WebModel\Request\AssignManagerRequest;
use App\WebModel\Request\OrganizationRequest;
use Illuminate\Support\Facades\Validator;

class OrganizationServiceImpl implements OrganizationService
{

    protected $organizationRepository;

    /**
     * @param OrganizationRepository $organizationRepository
     */

    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }


    public function getAll()
    {
        return $this->organizationRepository->getAll();
    }

    public function store(OrganizationRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validator = $this->validateData($request, 0);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organizationRepository->create($request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
        return redirect()->route('org.index')->with('success', MessageResponse::SUCCESS_CREATED);

    }

    public function findById($id)
    {
        return $this->organizationRepository->findById($id);
    }

    public function update(OrganizationRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $validator = $this->validateData($request, $id);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organizationRepository->update($id, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
        return redirect()->route('org.index')->with('success', MessageResponse::SUCCESS_UPDATED);
    }

    public function delete($id): bool
    {
            return $this->organizationRepository->delete($id);
    }


    public function storeManager($id, AssignManagerRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make((array)$request, [
            'managerId'  => 'required|exists:'.TableName::TABLE_ACCOUNT_MANAGER.',id'
        ]);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organizationRepository->addManager($id, $request->managerId);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.index')->with('success',MessageResponse::SUCCESS_CREATED);
    }

    private function validateData(OrganizationRequest $request, $id): \Illuminate\Contracts\Validation\Validator
    {
        $ruleOnUpdate = '';
        if (!empty($id)){
            $ruleOnUpdate =','.$id;
        }
        return Validator::make((array)$request, [
            'name'      => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:'.TableName::TABLE_ORGANIZATION.',email'.$ruleOnUpdate,
            'website'   => 'required|url',
            'logo'      => 'required|image|mimes:png,jpg,jpeg'
        ]);

    }
}
