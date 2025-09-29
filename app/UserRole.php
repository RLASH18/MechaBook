<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case Employee = 'employee';
    case Customer = 'customer';
}
