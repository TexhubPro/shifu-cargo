<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Слишком много запросов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            color: #1f2933;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.1);
            max-width: 420px;
            text-align: center;
        }
        h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        p {
            margin: 0.5rem 0;
            line-height: 1.4;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Пожалуйста, сделайте паузу</h1>
    <p>Вы слишком часто отправляете одинаковые запросы.</p>
    <p>Повторите попытку через небольшое время.</p>
</div>
</body>
</html>
