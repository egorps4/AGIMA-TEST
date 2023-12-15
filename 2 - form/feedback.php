<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email!";
    }
    if (mb_strlen($name, "UTF-8") > 20) {
        $errors[] = "Имя не должно превышать 20 символов!";
    }
    if (!is_numeric($rating) || $rating < 0 || $rating > 10) {
        $errors[] = "Оцените страницу!";
    }
    if (mb_strlen($comment, "UTF-8") > 500) {
        $errors[] = "Комментарий не должен превышать 500 символов!";
    }

    if (empty($errors)) {
        $data = [
            'email' => $email,
            'name' => $name,
            'rating' => $rating,
            'comment' => $comment
        ];

        $jsonData = file_get_contents('feedback.json');
        $feedbacks = json_decode($jsonData, true) ?: [];
        $feedbacks[] = $data;

        file_put_contents('feedback.json', json_encode($feedbacks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['Форма должна быть отправлена методом POST']]);
}

?>