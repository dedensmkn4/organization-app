<?php

namespace App\Services\Impl;

use App\Constant\Fields\OrganizationField;
use App\Constant\MessageResponse;
use App\Constant\TableName;
use App\Repositories\PersonRepository;
use App\Services\Api\PersonService;
use App\WebModel\Request\PersonRequest;
use Illuminate\Support\Facades\Validator;

class PersonServiceImpl implements PersonService
{

    protected $personRepository;

    /**
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function store($orgId, PersonRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validator = $this->validateData($request, 0);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->personRepository->create($orgId, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.detail', $orgId)->with('success',MessageResponse::SUCCESS_CREATED);
    }

    public function findById($orgId, $id)
    {
        return $this->personRepository->findById($orgId, $id);
    }

    public function update($orgId, $id, PersonRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validator = $this->validateData($request, $id);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->personRepository->update($orgId, $id, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.detail', $orgId)->with('success',MessageResponse::SUCCESS_UPDATED);
    }

    public function delete($orgId, $id): bool
    {
        return $this->personRepository->delete($orgId, $id);
    }

    private function validateData(PersonRequest $request, $id): \Illuminate\Contracts\Validation\Validator
    {
        $ruleOnUpdate = '';
        if (!empty($id)){
            $ruleOnUpdate =','.$id;
        }
        return Validator::make((array)$request, [
            'name'      => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:'.TableName::TABLE_PERSON.',email'.$ruleOnUpdate,
            'avatar'    => 'required|image|mimes:png,jpg,jpeg'
        ]);

    }
}
