<?php
require_once __DIR__ . '/../config/check_login.php';
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];
$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header('Location: index.php');
    exit();
}

// Fetch item only if it belongs to this user
$stmt = $pdo->prepare("SELECT id, title, description FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title)) {
        $error = 'Title is required.';
    } else {
        $stmt = $pdo->prepare("UPDATE items SET title = ?, description = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $id, $user_id]);
        header('Location: index.php?updated=1');
        exit();
    }
} else {
    $title = $item['title'];
    $description = $item['description'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/form-page.css" rel="stylesheet">
</head>
<body class="form-page">
    <div class="container">
        <div class="form-card">
            <a href="index.php" class="back-link">&larr; Back to list</a>
            <h2 class="form-page-title">Edit Item</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required
                        value="<?php echo htmlspecialchars($title); ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <button type="submit" class="btn btn-save">Update</button>
                <a href="index.php" class="btn-cancel">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
