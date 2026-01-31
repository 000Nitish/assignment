<?php
require_once __DIR__ . '/../config/check_login.php';
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title)) {
        $error = 'Title is required.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO items (user_id, title, description) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $description]);
        header('Location: index.php?added=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/form-page.css" rel="stylesheet">
</head>
<body class="form-page">
    <div class="container">
        <div class="form-card">
            <a href="index.php" class="back-link">&larr; Back to list</a>
            <h2 class="form-page-title">Add Item</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required
                        value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="btn btn-save">Save</button>
                <a href="index.php" class="btn-cancel">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
