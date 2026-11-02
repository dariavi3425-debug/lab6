<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Отримання та базове фільтрування вхідних даних
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $genre = htmlspecialchars(trim($_POST['genre'] ?? ''));
    $format = htmlspecialchars(trim($_POST['format'] ?? ''));
    $feedback = htmlspecialchars(trim($_POST['feedback'] ?? ''));

    // Перевірка заповнення обов'язкових полів
    if (empty($name) || empty($email)) {
        die("Помилка: будь ласка, заповніть усі обов'язкові поля.");
    }

    // Фіксація поточного часу та дати
    $dateTime = date("Y-m-d H:i:s");
    $fileTimestamp = date("Y-m-d_H-i-s");

    // Формування масиву з даними опитування
    $surveyData = [
        "submitted_at" => $dateTime,
        "respondent" => [
            "name" => $name,
            "email" => $email
        ],
        "answers" => [
            "favorite_genre" => $genre,
            "reading_format" => $format,
            "feedback" => $feedback
        ]
    ];

    // Перевірка та створення директорії survey за необхідності
    $dir = __DIR__ . '/survey';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Формування шляху та збереження даних у JSON-файл
    $filename = $dir . '/survey_' . $fileTimestamp . '.json';
    file_put_contents($filename, json_encode($surveyData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    // Відображення результату користувачеві
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head>
        <meta charset="UTF-8">
        <title>Дякуємо за відповідь!</title>
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 50px auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
            .success { color: #27ae60; margin-top: 0; }
            .info { background: #ebf5fb; padding: 12px 15px; border-left: 4px solid #3498db; margin: 20px 0; border-radius: 0 4px 4px 0; }
            a { color: #3498db; text-decoration: none; font-weight: 600; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <h2 class="success">Дякуємо, <?php echo $name; ?>!</h2>
        <p>Вашу відповідь було успішно зафіксовано та збережено на сервері.</p>
        
        <div class="info">
            <strong>Дата та час заповнення форми:</strong> <?php echo $dateTime; ?>
        </div>

        <p><a href="index.php">&larr; повернутися до форми</a></p>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}