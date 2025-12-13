<?php
class EnvLoader {
    public static function load($path) {
        if (!file_exists($path)) {
            die("Không tìm thấy file .env!");
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), "#") === 0) continue;

            list($key, $value) = explode("=", $line, 2);

            $key = trim($key);
            $value = trim($value);

            putenv("$key=$value");
        }
    }
}
