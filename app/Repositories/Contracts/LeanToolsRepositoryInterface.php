<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface LeanToolsRepositoryInterface
{
    /**
     * @param int|LeanTool $tool
     * @param string $name
     * @return Collection
     */
    public function getToolDetailsByName($tool,string  $name):Collection; // return type can be changed, name Ex. overview

}