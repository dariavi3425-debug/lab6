<?php
require_once 'functions.php';

$error = '';

// Фіксовані дані для входу
$correct_login = 'admin';
$correct_pass = '12345';

// Обробка авторизації
if (isset($_POST['login_btn'])) {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if ($user === $correct_login && $pass === $correct_pass) {
        $_SESSION['is_admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Невірний логін або пароль! Введено: '$user'";
    }
}

// Обробка дій
if (is_admin_logged_in()) {
    $action = $_GET['action'] ?? '';

    if ($action === 'logout') {
        logout_admin();
        header("Location: admin.php");
        exit();
    }

    if ($action === 'delete' && !empty($_GET['file'])) {
        delete_response_file($_GET['file']);
        header("Location: admin.php");
        exit();
    }

    if ($action === 'export') {
        export_responses_to_csv();
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Адмін-панель</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 850px; margin: 30px auto; padding: 0 20px; background-color: #f4f6f9; color: #333; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #3498db; padding-bottom: 12px; margin-bottom: 20px; }
        .btn { padding: 8px 14px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; }
        .btn-export { background: #27ae60; color: white; }
        .btn-logout { background: #e74c3c; color: white; }
        .btn-delete { background: #ff4d4d; color: white; padding: 4px 8px; font-size: 12px; border-radius: 3px; }
        .survey-card { background: white; border: 1px solid #e0e0e0; border-left: 5px solid #3498db; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .login-box { max-width: 360px; margin: 80px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; background: #3498db; color: white; padding: 10px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .error { color: #e74c3c; text-align: center; margin-bottom: 15px; font-weight: bold; }
        .hint { background: #e8f4fc; padding: 8px; border-radius: 4px; font-size: 13px; color: #2980b9; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>

<?php if (is_admin_logged_in()): ?>

    <div class="header">
        <h2>Адміністративна панель</h2>
        <div>
            <a href="admin.php?action=export" class="btn btn-export">📥 Експорт в CSV</a>
            <a href="admin.php?action=logout" class="btn btn-logout">Вийти</a>
        </div>
    </div>

    <?php $responses = get_all_responses(); ?>
    <p>Усього збережено відповідей у <code>survey/</code>: <strong><?php echo count($responses); ?></strong></p>

    <?php foreach ($responses as $r): ?>
        <div class="survey-card">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <strong>📅 <?php echo htmlspecialchars($r['submitted_at'] ?? ''); ?></strong>
                <a href="admin.php?action=delete&file=<?php echo urlencode($r['_filename']); ?>" class="btn btn-delete" onclick="return confirm('Видалити цю відповідь?');">🗑️ Видалити</a>
            </div>
            <p><strong>👤 Респондент:</strong> <?php echo htmlspecialchars($r['respondent']['name'] ?? ''); ?> (<em><?php echo htmlspecialchars($r['respondent']['email'] ?? ''); ?></em>)</p>
            <p><strong>📚 Жанр:</strong> <?php echo htmlspecialchars($r['answers']['favorite_genre'] ?? ''); ?></p>
            <p><strong>📖 Формат:</strong> <?php echo htmlspecialchars($r['answers']['reading_format'] ?? ''); ?></p>
            <p><strong>💬 Відгук:</strong> <?php echo htmlspecialchars($r['answers']['feedback'] ?? ''); ?></p>
        </div>
    <?php endforeach; ?>

<?php else: ?>

    <div class="login-box">
        <h2 style="text-align: center; margin-top:0;">Вхід в адмін-панель</h2>
        
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>

        <form action="admin.php" method="POST">
            <div class="form-group">
                <label>Логін:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login_btn">Увійти</button>
        </form>

        <div class="hint">
            <strong>Дані для входу:</strong><br>
            Логін: <code>admin</code><br>
            Пароль: <code>12345</code>
        </div>
    </div>

<?php endif; ?>

</body>
</html>