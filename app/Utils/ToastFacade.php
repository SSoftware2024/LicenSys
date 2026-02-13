<?php

namespace App\Utils;


use App\Enum\ToastType;

final class ToastFacade {
    private static int $duration = 5000;
    private static function make(string $message, ToastType $type, ?int $duration = null) : array
    {
        return [
            'message' => $message,
            'type' => $type->value,
            'duration' => $duration ?: self::$duration
        ];
    }
    private static function createSession(array $dataToast){
        session()->flash(RESPONSE_DATA_KEY_INERTIA, [
            'toast' => $dataToast
        ]);
    }

    public static function default(string $message, ?int $duration = null) : array
    {
        $array = self::make($message, ToastType::DEFAULT, $duration);
        self::createSession($array);
        return $array;
    }
    public static function info(string $message, ?int $duration = null) : array
    {
        $array = self::make($message, ToastType::INFO, $duration);
        self::createSession($array);
        return $array;
    }
    public static function success(string $message, ?int $duration = null) : array
    {
        $array = self::make($message, ToastType::SUCCESS, $duration);
        self::createSession($array);
        return $array;
    }
    public static function warning(string $message, ?int $duration = null) : array
    {
        $array = self::make($message, ToastType::WARNING, $duration);
        self::createSession($array);
        return $array;
    }
    public static function error(string $message, ?int $duration = null) : array
    {
        $array = self::make($message, ToastType::ERROR, $duration);
        self::createSession($array);
        return $array;
    }
}
