<?php

namespace App\Enums;

enum UserRole: int
{
    case SUPERADMIN = 1;
    case ADMIN = 2;
    case USER = 3;

}
