<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Rejected = 'rejected';
}