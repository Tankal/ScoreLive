<?php
declare(strict_types=1);

session_start();

function env_value(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

try {
    $dbHost = env_value('DB_HOST', 'localhost');
    $dbName = env_value('DB_NAME', 'jetskor');
    $dbUser = env_value('DB_USER', 'root');
    $dbPass = env_value('DB_PASS', '');
    $dbCharset = env_value('DB_CHARSET', 'utf8mb4');

    $db = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection failed. Please check your local environment configuration.');
}

date_default_timezone_set('Europe/Istanbul');
$bugun = date("Y-m-d H:i:s");
$bugunGun = date("Y-m-d");
$kullanici_id = isset($_SESSION["user"]) ? (int) $_SESSION["user"] : null;
?>
