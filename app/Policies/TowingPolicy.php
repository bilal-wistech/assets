<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class TowingPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'towings_requests';
    }
}