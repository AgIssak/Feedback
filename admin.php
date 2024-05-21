<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', 'agibagi02', 'feedback_app');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM feedback ORDER BY date DESC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    if (isset($_POST['approve'])) {
        $conn->query("UPDATE feedback SET status = 'approved' WHERE id = $id");
    } elseif (isset($_POST['reject'])) {
        $conn->query("UPDATE feedback SET status = 'rejected' WHERE id = $id");
    } elseif (isset($_POST['edit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $conn->query("UPDATE feedback SET name = '$name', email = '$email', message = '$message', modified_by_admin = 1 WHERE id = $id");
    }
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Админ панель</h1>
<div class="feedback-list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="feedback-item">
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                <textarea name="message" required><?php echo htmlspecialchars($row['message']); ?></textarea>
                <?php if ($row['image']): ?>
                    <p><img src="uploads/<?php echo $row['image']; ?>" alt="Attached Image" width="100"></p>
                <?php endif; ?>
                <button type="submit" name="approve">Одобрить</button>
                <button type="submit" name="reject">Отклонить</button>
                <button type="submit" name="edit">Изменить</button>
            </form>
            <p>Status: <?php echo $row['status']; ?></p>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
