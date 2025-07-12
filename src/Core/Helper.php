<?php

namespace Ixcsoft\Registra\Core;

class Helper
{
    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function redirect(string $url)
    {
        header("Location: " . $url);
        exit();
    }

    public static function redirectWithSuccess(string $message, string $redirectUrl = 'index.php')
    {
        self::startSession();
        $_SESSION['flash_message_success'] = $message;
        self::redirect($redirectUrl);
    }

    public static function redirectWithError(string $message, string $redirectUrl = 'index.php')
    {
        self::startSession();
        $_SESSION['flash_message_error'] = $message;
        self::redirect($redirectUrl);
    }

    public static function getFlashSuccess(): ?string
    {
        self::startSession();
        if (isset($_SESSION['flash_message_success'])) {
            $message = $_SESSION['flash_message_success'];
            unset($_SESSION['flash_message_success']);
            return $message;
        }
        return null;
    }

    public static function getFlashError(): ?string
    {
        self::startSession();
        if (isset($_SESSION['flash_message_error'])) {
            $message = $_SESSION['flash_message_error'];
            unset($_SESSION['flash_message_error']);
            return $message;
        }
        return null;
    }
}