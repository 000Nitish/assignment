<?php
require_once __DIR__ . '/../config/check_login.php';
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];
$id = (int)($_GET['id'] ?? 0);

if ($id) {
    // Delete only if item belongs to this user
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
}

header('Location: index.php?deleted=1');
exit();
?>
