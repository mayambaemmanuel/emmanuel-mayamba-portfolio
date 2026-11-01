<?php
require __DIR__ . '/bootstrap.php';
if (!user_id()) go('account.php');
$id = user_id();
$statement = db()->prepare('SELECT name, email FROM users WHERE id = ?');
$statement->bind_param('i', $id);
$statement->execute();
$user = $statement->get_result()->fetch_assoc();
if (!$user) { unset($_SESSION['user_id']); go('account.php'); }
$statement = db()->prepare('SELECT message, created_at FROM messages WHERE user_id = ? ORDER BY id DESC LIMIT 100');
$statement->bind_param('i', $id);
$statement->execute();
$messages = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>My account | Portfolio</title><link rel="stylesheet" href="styles.css"></head><body>
<header class="site-header"><nav class="container navigation"><a class="logo" href="index.php">EM<span>.</span></a><form method="post" action="logout.php"><?= csrf_input() ?><button class="button button-primary">Log out</button></form></nav></header>
<main class="container section"><p class="eyebrow">My account</p><h1 class="dashboard-title">Hello, <?= e($user['name']) ?>.</h1><p><?= e($user['email']) ?></p><a class="button button-primary" href="index.php#contact">Write a message</a>
<section class="message-history"><h2>Your messages</h2><p>Your latest 100 messages, saved in the portfolio database. Times are shown in UTC.</p>
<?php if (!$messages): ?><p>You have not sent any messages yet.</p><?php endif; ?>
<?php foreach ($messages as $message): ?><article class="skill-card"><p class="eyebrow"><?= e($message['created_at']) ?> UTC</p><p class="message-body"><?= e($message['message']) ?></p></article><?php endforeach; ?>
</section></main></body></html>
