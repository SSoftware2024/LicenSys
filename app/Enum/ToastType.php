<?php
namespace App\Enum;
enum ToastType: string {
    case DEFAULT = 'default';
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
}
