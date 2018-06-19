<?php

namespace App\Repositories;


use App\Models\Invitation;
use App\Repositories\Contracts\InvitationRepositoryInterface;

class InvitationRepository extends BaseRepository implements InvitationRepositoryInterface
{

    public function model()
    {
        return new Invitation();
    }
}