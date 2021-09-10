<?php

namespace App\Services\Impl;

use App\Constant\MessageResponse;
use App\Repositories\ManagerRepository;
use App\Services\Api\ManagerService;
use App\WebModel\Request\ManagerRequest;
use Illuminate\Support\Facades\Validator;

class ManagerServiceImpl implements ManagerService
{

    protected $managerRepository;

    /**
     * @param ManagerRepository $managerRepository
     */
    public function __construct(ManagerRepository $managerRepository)
    {
        $this->managerRepository = $managerRepository;
    }

    public function getAll()
    {
        return $this->managerRepository->getAll();
    }

    public function store(ManagerRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validator = $this->validateData($request);

        if($validator->fails()){
            return back()->withInput((array)$request)->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->managerRepository->create($request);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('manager.index')->with('success',
            MessageResponse::SUCCESS_CREATED);
    }

    public function findById($id)
    {
        return $this->managerRepository->findById($id);
    }

    public function update(ManagerRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $this->managerRepository->update($id, $request);

        return redirect()->route('manager.index')->with('success', MessageResponse::SUCCESS_UPDATED);
    }

    public function delete($id): bool
    {
       return $this->managerRepository->delete($id);
    }

    private function validateData(ManagerRequest $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make((array)$request, [
            'name' => 'required|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

    }



}
