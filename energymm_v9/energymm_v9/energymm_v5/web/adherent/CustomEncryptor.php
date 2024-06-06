<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("../php/log_BD.php");


class CustomEncryptor {
    private const KEY = "grp10";

    public static function encrypt($plaintext) {
        $encryptedText = '';
        $keyLength = strlen(self::KEY);
        for ($i = 0; $i < strlen($plaintext); $i++) {
            $encryptedChar = ord($plaintext[$i]) + ord(self::KEY[$i % $keyLength]);
            $encryptedText .= chr($encryptedChar);
        }
        return $encryptedText;
    }

    public static function decrypt($encryptedText) {
        $decryptedText = '';
        $keyLength = strlen(self::KEY);
        for ($i = 0; $i < strlen($encryptedText); $i++) {
            $decryptedChar = ord($encryptedText[$i]) - ord(self::KEY[$i % $keyLength]);
            $decryptedText .= chr($decryptedChar);
        }
        return $decryptedText;
    }
}
?>
