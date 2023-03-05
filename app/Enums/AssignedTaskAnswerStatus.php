<?php

namespace App\Enums;

enum AssignedTaskAnswerStatus: string
{
    case DRAFT = 'draft';
    case AUTO_REJECTED = 'auto-rejected';
    case SENT = 'sent';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
