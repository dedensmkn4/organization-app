<?php

namespace App\Http\Controllers;

use App\Constant\MessageResponse;
use App\Services\Api\OrganizationService;
use App\Services\Api\PersonService;
use App\WebModel\Request\PersonRequest;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $personService;
    protected $organizationService;

    /**
     * @param PersonService $personService
     * @param OrganizationService $organizationService
     */
    public function __construct(PersonService $personService, OrganizationService $organizationService)
    {
        $this->personService = $personService;
        $this->organizationService = $organizationService;
    }

    public function create($orgId)
    {
        $organization = $this->organizationService->findById($orgId);
        if(!$organization){
            return redirect()->route('org.index')->with('error', MessageResponse::NOT_FOUND);
        }

        return view('pic.create',compact('organization'));
    }

    public function store($orgId, Request $request)
    {
        return $this->personService->store($orgId, $this->toPersonRequest($request));
    }

    public function detail($orgId, $id)
    {

        $person = $this->personService->findById($orgId, $id);
        if(!$person) {
            return redirect()->route('org.detail',$orgId)->with('error',MessageResponse::NOT_FOUND);
        }

        return view('pic.detail', compact('person'));
    }

    public function update($orgId, $id, Request $request)
    {
        return $this->personService->update($orgId, $id, $this->toPersonRequest($request));
    }

    public function delete($orgId, $id): \Illuminate\Http\RedirectResponse
    {
        $isDeleted = $this->personService->delete($orgId, $id);
        if ($isDeleted){
            return redirect()->route('org.detail', $orgId)->with('success',
                MessageResponse::SUCCESS_DELETED);
        }
        return redirect()->route('org.detail', $orgId)->with('error',MessageResponse::FAILED_DELETED);
    }


    private function toPersonRequest(Request $request):PersonRequest{
        $personRequest = new PersonRequest();
        $personRequest->setName($request->input('fullname'));
        $personRequest->setPhone($request->input('phone'));
        $personRequest->setEmail($request->input('email'));
        $personRequest->setAvatar($request->file('avatar'));

        return $personRequest;
    }
}
