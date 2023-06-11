<?php

namespace App\Enums\Roles;

enum RoleNamesEnum: string
{
    const PRINCIPAL = 'principal';
    const EMPLOYEE = 'employee';

    const PRINCIPAL_ID = 1;
    const EMPLOYEE_ID = 2;
}
