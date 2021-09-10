<?php

namespace App\WebModel\Request;

class AssignManagerRequest
{

    public $managerId;

    /**
     * @param $managerId
     */
    public function __construct($managerId)
    {
        $this->managerId = $managerId;
    }

    /**
     * @return mixed
     */
    public function getManagerId()
    {
        return $this->managerId;
    }

    /**
     * @param mixed $managerId
     */
    public function setManagerId($managerId): void
    {
        $this->managerId = $managerId;
    }


}
