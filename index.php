<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опитування: Читацькі вподобання</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 40px auto; padding: 0 20px; color: #333; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .form-group { margin-bottom: 18px; }
        label { font-weight: 600; display: block; margin-bottom: 6px; }
        input[type="text"], input[type="email"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        button { background-color: #3498db; color: white; padding: 12px 20px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; transition: background 0.3s; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <h2>Опитування: Читацькі вподобання та формати</h2>
    <form action="process.php" method="POST">
        
        <div class="form-group">
            <label for="name">Ваше ім'я:</label>
            <input type="text" id="name" name="name" required placeholder="Введіть ваше ім'я">
        </div>

        <div class="form-group">
            <label for="email">Ваш Email:</label>
            <input type="email" id="email" name="email" required placeholder="example@mail.com">
        </div>

        <div class="form-group">
            <label for="genre">Який ваш улюблений жанр книг?</label>
            <select id="genre" name="genre">
                <option value="Фентезі">Фентезі</option>
                <option value="Детектив">Детектив</option>
                <option value="Наукова фантастика">Наукова фантастика</option>
                <option value="Романтика">Романтика</option>
                <option value="Сучасна проза">Сучасна проза</option>
            </select>
        </div>

        <div class="form-group">
            <label for="format">В якому форматі найчастіше читаєте?</label>
            <select id="format" name="format">
                <option value="Паперові книги">Паперові книги</option>
                <option value="Електронні книги (e-book)">Електронні книги (e-book)</option>
                <option value="Аудіокниги">Аудіокниги</option>
            </select>
        </div>

        <div class="form-group">
            <label for="feedback">Ваша улюблена книга або коментар:</label>
            <textarea id="feedback" name="feedback" rows="4" required placeholder="Поділіться вашими враженнями..."></textarea>
        </div>

        <button type="submit">Надіслати відповідь</button>
    </form>

</body>
</html>