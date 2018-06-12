<?php

namespace App\Services;

use App\Repositories\ActionItemRepository;
use App\Services\Contracts\ActionItemServiceInterface;

class ActionItemService implements ActionItemServiceInterface
{
    protected $actionItemRepository;
    public function __construct(ActionItemRepository $actionItemRepository)
    {
        $this->actionItemRepository=$actionItemRepository;
    }

    public function addActionItem($data): bool
    {
        // TODO: Implement addActionItem() method.
    }

    public function updateActionItem($data): bool
    {
        // TODO: Implement updateActionItem() method.
    }

    public function moveActionItemPosition($data): bool
    {
        // TODO: Implement moveActionItemPosition() method.
    }
    public function assignActionItemMember($data): bool
    {
        // TODO: Implement assignActionItemMember() method.
    }

    public function addActionItemChecklist($data): bool
    {
        // TODO: Implement addActionItemChecklist() method.
    }

    public function addActionItemComment($data): bool
    {
        // TODO: Implement addActionItemComment() method.
    }

    public function addActionItemAttachment($data): bool
    {
        // TODO: Implement addActionItemAttachment() method.
    }

    public function addActionItemLabel($data): bool
    {
        // TODO: Implement addActionItemLabel() method.
    }

    public function checkActionItemCheckList($data): bool
    {
        // TODO: Implement checkActionItemCheckList() method.
    }

    public function archiveActionItem($item): bool
    {
        // TODO: Implement archiveActionItem() method.
    }
}