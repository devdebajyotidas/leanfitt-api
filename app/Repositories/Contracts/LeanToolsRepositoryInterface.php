<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface LeanToolsRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllTools():Collection;

    /**
     * @param int|LeanTool $tool
     * @return Collection
     */
    public function getToolDetails($tool):Collection;

    /**
     * @param int|LeanTool $tool
     * @param string $name
     * @return Collection
     */
    public function getToolDetailsByName($tool,string  $name):Collection; // return type can be changed, name Ex. overview

    /**
     * @param int|LeanTool $tool
     * @return bool
     */
    public function isArchived($tool):bool;

    
}