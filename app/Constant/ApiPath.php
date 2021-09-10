<?php

namespace App\Constant;

class ApiPath
{
    public const ORGANIZATION_PATH = "organization";
    public const MANAGER_PATH = "manager";
    public const PERSON_PATH = "person";

    public const INDEX = "/";
    public const ID = "/{id}";
    public const ORG_ID = "/{org_id}";
    public const CREATE = "/create";
    public const DELETE = self::ID."/delete";
    public const DETAIL = self::ID."/detail";
    public const ASSIGN_MANAGER = self::ID."/assign-mgr";

}
