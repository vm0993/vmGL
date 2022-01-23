<?php

namespace App\Policies\Accounting;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashBankPolicy
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
