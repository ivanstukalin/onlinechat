<?php

namespace App\Enums;

enum MessageTypeEnum: string
{
    case User     = 'user';
    case Operator = 'operator';
    case System   = 'system';
}