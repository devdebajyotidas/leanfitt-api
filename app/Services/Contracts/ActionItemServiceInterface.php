<?php

namespace App\Services\Contracts;

use App\Models\ActionItem;

interface ActionItemServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function addActionItem($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateActionItem($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function moveActionItemPosition($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function assignActionItemMember($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function addActionItemChecklist($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function addActionItemComment($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function addActionItemAttachment($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function addActionItemLabel($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function checkActionItemCheckList($data):bool;

    /**
     * @param int|ActionItem $item
     * @return bool
     */
    public function archiveActionItem($item):bool;
}