<?php

namespace App\Http\Controllers;

use App\Constant\MessageResponse;
use App\Services\Api\ManagerService;
use App\WebModel\Request\ManagerRequest;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $managerService;

    /**
     * @param ManagerService $managerService
     */
    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function index()
    {
        $managers = $this->managerService->getAll();
        return view('manager.index',compact('managers'));
    }

    public function create()
    {
        return view('manager.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        return $this->managerService->store($this->toManagerRequest($request));
    }

    public function detail($id)
    {
        $manager = $this->managerService->findById($id);
        if(!$manager){
            return redirect()->route('manager.index')->with('error','Account Manager Not Found');
        }

        return view('manager.detail', compact('manager'));
    }

    public function update($id, Request $request): \Illuminate\Http\RedirectResponse
    {
        return $this->managerService->update($this->toManagerRequest($request), $id);
    }

    public function delete($id)
    {
        try {
            $this->managerService->delete($id);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('manager.index')->with('success', MessageResponse::SUCCESS_DELETED);
    }


    private function toManagerRequest(Request $request):ManagerRequest{
        $mangerRequest = new ManagerRequest();
        $mangerRequest->setName($request->input('fullname'));
        $mangerRequest->setEmail($request->input('email'));
        $mangerRequest->setPassword($request->input('password'));

        return $mangerRequest;
    }
}
