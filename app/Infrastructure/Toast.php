<?php

namespace App\Infrastructure;

use App\Enums\ToastType;
use Illuminate\Support\Facades\Session;

class Toast
{
    private const SESSION_TOASTS_KEY = 'toasts';

    public static function push(string $msg, ToastType $type): void
    {
        Session::push(self::SESSION_TOASTS_KEY, [
            'text' => $msg,
            'type' => $type->value,
        ]);
    }

    public static function pull(): array
    {
        return Session::pull(self::SESSION_TOASTS_KEY, []);
    }

    public static function default(string $msg): void
    {
        self::push($msg, ToastType::DEFAULT);
    }

    public static function info(string $msg): void
    {
        self::push($msg, ToastType::INFO);
    }

    public static function success(string $msg): void
    {
        self::push($msg, ToastType::SUCCESS);
    }

    public static function warning(string $msg): void
    {
        self::push($msg, ToastType::WARNING);
    }

    public static function error(string $msg): void
    {
        self::push($msg, ToastType::ERROR);
    }
}
