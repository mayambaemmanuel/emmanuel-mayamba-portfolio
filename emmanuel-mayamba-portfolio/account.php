<?php
require __DIR__ . '/bootstrap.php';
if (user_id()) go('dashboard.php');
$register = ($_GET['mode'] ?? '') === 'register';
$title = $register ? 'Create an account' : 'Welcome back';
$name = trim((string) ($_POST['name'] ?? ''));
$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    if (!csrf_valid()) {
        $error = 'Your form expired. Please try again.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $error = 'Please enter a valid email address.';
    } elseif ($register && ($name === '' || strlen($name) > 100)) {
        $error = 'Enter a name of up to 100 characters.';
    } elseif (strlen($password) < 8 || strlen($password) > 72) {
        $error = 'Use a password between 8 and 72 bytes (at least 8 characters).';
    } elseif ($register && $password !== ($_POST['confirm_password'] ?? '')) {
        $error = 'Your passwords do not match.';
    } else {
        if ($register) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $statement = db()->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
                $statement->bind_param('sss', $name, $email, $hash);
                $statement->execute();
                $id = db()->insert_id;
            } catch (mysqli_sql_exception $exception) {
                if ($exception->getCode() !== 1062) throw $exception;
                $error = 'An account already uses this email. Please log in.';
            }
        } else {
            $statement = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $user = $statement->get_result()->fetch_assoc();
            if ($user && password_verify($password, $user['password_hash'])) {
                $id = $user['id'];
            } else {
                $error = 'Incorrect email or password.';
            }
        }
        if ($error === '') {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $id;
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            go('dashboard.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= e($title) ?> | Emmanuel Mayamba</title><link rel="stylesheet" href="styles.css"></head>
<body><header class="site-header"><nav class="container navigation"><a class="logo" href="index.php">EM<span>.</span></a><a href="index.php">Back to portfolio</a></nav></header>
<main class="account-shell"><p class="eyebrow">Your portfolio account</p><h1><?= e($title) ?></h1><p>Sign in to send messages and view your message history.</p>
<?php if ($error): ?><p class="account-error" role="alert"><?= e($error) ?></p><?php endif; ?>
<form method="post" class="account-form">
<?= csrf_input() ?>
<?php if ($register): ?><label for="name">Your name</label><input id="name" name="name" required maxlength="100" autocomplete="name" value="<?= e($name) ?>"><?php endif; ?>
<label for="email">Email address</label><input id="email" name="email" type="email" required maxlength="254" autocomplete="email" value="<?= e($email) ?>">
<label for="password">Password</label><input id="password" name="password" type="password" required minlength="8" maxlength="72" autocomplete="<?= $register ? 'new-password' : 'current-password' ?>" aria-describedby="password-help">
<p id="password-help">Use 8–72 characters. For non-ASCII characters, the maximum is 72 bytes.</p>
<?php if ($register): ?><label for="confirm-password">Confirm password</label><input id="confirm-password" name="confirm_password" type="password" required minlength="8" maxlength="72" autocomplete="new-password"><?php endif; ?>
<button class="button button-primary" type="submit"><?= $register ? 'Register' : 'Log in' ?></button>
</form><p class="account-switch"><?= $register ? 'Already have an account?' : 'New here?' ?> <a class="text-link" href="account.php<?= $register ? '' : '?mode=register' ?>"><?= $register ? 'Log in' : 'Create an account' ?></a></p></main></body></html>
