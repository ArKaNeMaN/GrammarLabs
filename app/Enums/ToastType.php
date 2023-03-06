<?php

namespace App\Enums;

enum ToastType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case WARNING = 'warning';
    case DEFAULT = 'default';
    case INFO = 'info';
}
