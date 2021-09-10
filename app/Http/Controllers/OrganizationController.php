<?php

namespace App\Http\Controllers;

use App\Constant\MessageResponse;
use App\Services\Api\ManagerService;
use App\Services\Api\OrganizationService;
use App\WebModel\Request\AssignManagerRequest;
use App\WebModel\Request\OrganizationRequest;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    protected $organizationService;
    protected $managerService;

    /**
     * @param OrganizationService $organizationService
     * @param ManagerService $managerService
     */
    public function __construct(OrganizationService $organizationService, ManagerService $managerService)
    {
        $this->organizationService = $organizationService;
        $this->managerService = $managerService;
    }


    public function index(){
        $organizations = $this->organizationService->getAll();
        return view('organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('organization.create');
    }

    public function store(Request $request)
    {
        return $this->organizationService->store($this->toOrganizationRequest($request));
    }

    public function detail($id)
    {
        $organization = $this->organizationService->findById($id);
        if(!$organization){
            return redirect()->route('org.index')->with('error', MessageResponse::NOT_FOUND);
        }

        return view('organization.detail',compact('organization'));
    }

    public function update($id, Request $request)
    {
        return $this->organizationService->update($this->toOrganizationRequest($request), $id);
    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        $isDeleted = $this->organizationService->delete($id);
        if ($isDeleted){
            return redirect()->route('org.index')->with('success',
                MessageResponse::SUCCESS_DELETED);
        }
        return redirect()->route('org.index')->with('error',MessageResponse::FAILED_DELETED);
    }
    public function getManager($id)
    {
        $organization = $this->organizationService->findById($id);
        if (empty($organization)){
            return redirect()->route('org.index')->with('error',
                MessageResponse::NOT_FOUND);
        }
        $managers = $this->managerService->getAll();

        return view('organization.add-manager',compact('organization','managers'));
    }

    public function storeManager($id, Request $request)
    {
        return $this->organizationService->storeManager($id, $this->toAssignManagerRequest($request));
    }


    private function toOrganizationRequest(Request $request):OrganizationRequest{
        $organizationRequest = new OrganizationRequest();
        $organizationRequest->setName($request->input('fullname'));
        $organizationRequest->setPhone($request->input('phone'));
        $organizationRequest->setEmail($request->input('email'));
        $organizationRequest->setWebsite($request->input('website'));
        $organizationRequest->setLogo($request->file('logo'));

        return $organizationRequest;
    }

    private function toAssignManagerRequest(Request $request):AssignManagerRequest{
        return new AssignManagerRequest($request->input('managerId'));
    }


}
