<?php

namespace Modules\Task\Enums;

enum TaskStatusEnum: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
