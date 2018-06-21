<?php

namespace App\Services\Contracts;

use App\Models\LeanTool;

interface LeanToolServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
     public function addLeanTool($data):bool;

    /**
     * @param $data
     * @return bool
     */
     public function updateLeanTool($data):bool;

    /**
     * @param int|LeanTool $tool
     * @return bool
     */
     public function removeLeanTools($tool):bool;
}