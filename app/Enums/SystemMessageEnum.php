<?php

namespace App\Enums;

enum SystemMessageEnum: string
{
    case OperatorActive = 'operator_active';
    case QuestionClosed = 'question_closed';
}