<?php
require_once __DIR__ . '/../config/check_login.php';
require_once __DIR__ . '/../config/db.php';

$user_id = $_SESSION['user_id'];

// Fetch all items for this user
$stmt = $pdo->prepare("SELECT id, title, description, created_at FROM items WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>
<body class="dashboard-page">
    <div class="container">
        <div class="dashboard-header">
            <h1>My Items</h1>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="user-info">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="add.php" class="btn-add">Add Item</a>
                <a href="../auth/logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <div class="dashboard-content">
            <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">Item deleted successfully.</div>
            <?php endif; ?>
            <?php if (isset($_GET['added'])): ?>
                <div class="alert alert-success">Item added successfully.</div>
            <?php endif; ?>
            <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Item updated successfully.</div>
            <?php endif; ?>

            <?php if (empty($items)): ?>
                <div class="dashboard-empty">
                    <p>No items yet.</p>
                    <a href="add.php">Add your first item</a>
                </div>
            <?php else: ?>
                <table class="table items-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo htmlspecialchars($item['description'] ?? '-'); ?></td>
                            <td><?php echo date('M j, Y', strtotime($item['created_at'])); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo (int)$item['id']; ?>" class="btn-edit">Edit</a>
                                <a href="delete.php?id=<?php echo (int)$item['id']; ?>" class="btn-delete"
                                    onclick="return confirm('Delete this item?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
