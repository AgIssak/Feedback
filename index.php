<?php
$conn = new mysqli('localhost', 'root', 'agibagi02', 'feedback_app');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date';
$order = ($sort_by === 'date') ? 'ASC' : 'DESC';

switch ($sort_by) {
    case 'name':
        $order_by = 'name';
        $order = 'ASC';
        break;
    case 'email':
        $order_by = 'email';
        $order = 'ASC';
        break;
    default:
        $order_by = 'date';
        break;
}

$result = $conn->query("SELECT * FROM feedback WHERE status = 'approved' ORDER BY $order_by");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h3>Сортировать по:</h3>
    <form method="GET" action="index.php">
        <div class="sort-container">
            <select name="sort_by" onchange="this.form.submit()">
                <option value="date" <?php if ($sort_by == 'date') echo 'selected'; ?>>Дате</option>
                <option value="name" <?php if ($sort_by == 'name') echo 'selected'; ?>>Имя</option>
                <option value="email" <?php if ($sort_by == 'email') echo 'selected'; ?>>E-mail</option>
            </select>
        </div>
        
    </form>

    <h1>Отзывы</h1>
    <div class="feedback-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="feedback-item">
                <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo htmlspecialchars($row['email']); ?>) <?php if ($row['modified_by_admin']) echo "(изменен администратором)"; ?></p>
                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                <?php if ($row['image']): ?>
                    <p><img src="uploads/<?php echo $row['image']; ?>" alt="Attached Image" width="100"></p>
                <?php endif; ?>
                <p><em><?php echo $row['date']; ?></em></p>
            </div>
        <?php endwhile; ?>
    </div>

    <h2>Оставьте свой отзыв</h2>
    <form id="feedback-form" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="message" placeholder="Ваш отзыв" required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Отправить</button>
    </form>

    <script src="script.js"></script>

</body>

</html>