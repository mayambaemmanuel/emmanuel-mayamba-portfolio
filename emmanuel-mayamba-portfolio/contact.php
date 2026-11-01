<?php
require __DIR__ . '/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');
function reply(int $status, string $message): never {
    http_response_code($status);
    echo json_encode(['message' => $message]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') reply(405, 'Please submit the contact form.');
if (!csrf_valid()) reply(403, 'Your form expired. Refresh the page and try again.');
if (!user_id()) reply(401, 'Please log in before sending a message.');
$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
if ($name === '' || mb_strlen($name) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254 || $message === '' || mb_strlen($message) > 2000) {
    reply(422, 'Enter a name, valid email, and a message of up to 2,000 characters.');
}
try {
    $id = user_id();
    $statement = db()->prepare('INSERT INTO messages (user_id, name, email, message) VALUES (?, ?, ?, ?)');
    $statement->bind_param('isss', $id, $name, $email, $message);
    $statement->execute();
    reply(201, 'Your message has been saved. You can view it in My account.');
} catch (mysqli_sql_exception $error) {
    error_log((string) $error);
    reply(503, 'Unable to save your message right now. Please try again.');
}
