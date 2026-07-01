<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'URL Shortener') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            color: #fff;
        }
        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 3rem;
            max-width: 520px;
            text-align: center;
        }
        h1 { font-size: 2rem; margin-bottom: 0.75rem; }
        p { color: rgba(255, 255, 255, 0.75); line-height: 1.6; margin-bottom: 2rem; }
        .actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        a.btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        a.btn-primary {
            background: #f59e0b;
            color: #1e1b4b;
        }
        a.btn-secondary {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        a.btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.25); }
    </style>
</head>
<body>
    <div class="card">
        <h1>URL Shortener</h1>
        <p>Сокращайте ссылки, отслеживайте переходы и управляйте ими в личном кабинете.</p>
        <div class="actions">
            <a href="{{ url('/admin/register') }}" class="btn btn-primary">Регистрация</a>
            <a href="{{ url('/admin/login') }}" class="btn btn-secondary">Войти</a>
        </div>
    </div>
</body>
</html>
