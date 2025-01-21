<?php
// app/components/ErrorHandler.php
namespace app\components;

class ErrorHandler {
    static $error;
    public static function setError($message) {
        $_SESSION['error_message'] = $message;
    }

    public static function getError() {
        $error = $_SESSION['error_message'] ?? '';
        unset($_SESSION['error_message']);
        return $error;
    }
}