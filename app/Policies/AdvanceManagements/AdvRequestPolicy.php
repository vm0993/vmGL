<?php

namespace App\Policies\AdvanceManagements;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
