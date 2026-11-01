<?php
require_once __DIR__ . '/db.php';
ini_set('session.use_strict_mode', '1');
session_name('portfolio_session');
session_set_cookie_params([
    'httponly' => true, 'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);
session_start();
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));

function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function csrf_valid(): bool {
    return is_string($_POST['csrf'] ?? null) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}
function csrf_input(): string {
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}
function user_id(): ?int {
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}
function go(string $path): never {
    header('Location: ' . $path, true, 303);
    exit;
}
set_exception_handler(function (Throwable $error) {
    error_log((string) $error);
    http_response_code(503);
    echo 'The portfolio is temporarily unavailable. Check that XAMPP MySQL is running and database.sql has been imported.';
});
