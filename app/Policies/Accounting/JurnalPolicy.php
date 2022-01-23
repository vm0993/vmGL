<?php

namespace App\Policies\Accounting;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JurnalPolicy
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
