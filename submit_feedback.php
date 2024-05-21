<?php
$conn = new mysqli('localhost', 'root', 'agibagi02', 'feedback_app');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$image = null;

if ($_FILES['image']['size'] > 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check !== false && $_FILES["image"]["size"] <= 1048576 && in_array($imageFileType, ['jpg', 'png', 'gif'])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            echo "Ошибка при загрузке файла";
            exit;
        }
    } else {
        echo "Картинка должна быть не более 1mb. Допустимые форматы: JPG, GIF, PNG";
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO feedback (name, email, message, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $message, $image);
$stmt->execute();

echo "Спасибо за ваш отзыв!.";
?>