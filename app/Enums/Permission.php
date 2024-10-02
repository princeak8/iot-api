<?php

namespace App\Enums;

enum Permission: string
    {
        case VIEWING = 'viewing';
        case OPERATION = 'operation';
    }