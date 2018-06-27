<?php

namespace App\Repositories\Contracts;

use App\Models\ActionItem;
use App\Models\Board;
use App\Models\Department;
use App\Models\LeanTool;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ActionItemRepositoryInterface
{
    public function allProjectActions();

    public function allReportActions();

    public function getItem($id);
}