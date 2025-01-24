<?php
// app/components/ErrorHandler.php
namespace app\components;

class ErrorHandler {
    static $error;
    public static function setError($message) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $_SESSION['error_message'] = $message;
    }

    public static function getError() : string {
        $error = $_SESSION['error_message'] ?? '';
        return $error;
    }

    public static function reset() {
        unset($_SESSION["error_message"]);
    }
}