<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget Demo — Mini CRM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        pre { background: #1e1e2e; color: #cdd6f4; padding: 16px; border-radius: 8px; font-size: 13px; overflow-x: auto; }
        .copy-btn { font-size: 12px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="h3 mb-1">Widget Demo Page</h1>
        <p class="text-muted mb-5">Тестовая страница виджета обратной связи</p>

        <div class="row g-5">
            <div class="col-lg-5">
                <h5 class="mb-3">Предпросмотр виджета</h5>
                <iframe src="/widget"
                        width="100%"
                        height="620"
                        style="border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08);"
                        title="Виджет обратной связи">
                </iframe>
            </div>

            <div class="col-lg-7">
                <h5 class="mb-3">Код для вставки на сайт</h5>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">HTML (iframe)</span>
                    <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode(this, 'embed-code')">
                        Копировать
                    </button>
                </div>
                <pre id="embed-code">&lt;iframe
  src="{{ url('/widget') }}"
  width="500"
  height="620"
  frameborder="0"
  style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1);"
  title="Форма обратной связи"
&gt;&lt;/iframe&gt;</pre>

                <h5 class="mt-5 mb-3">API: создание заявки</h5>
                <p class="text-muted small mb-2"><code>POST /api/tickets</code></p>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">cURL</span>
                    <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode(this, 'api-code')">
                        Копировать
                    </button>
                </div>
                <pre id="api-code">curl -X POST {{ url('/api/tickets') }} \
  -F "name=Иван Иванов" \
  -F "phone=+380991234567" \
  -F "email=ivan@example.com" \
  -F "subject=Нужна консультация" \
  -F "body=Хочу узнать о ваших услугах"</pre>

                <h5 class="mt-5 mb-3">API: статистика заявок</h5>
                <p class="text-muted small mb-2"><code>GET /api/tickets/statistics</code></p>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small">cURL</span>
                    <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyCode(this, 'stats-code')">
                        Копировать
                    </button>
                </div>
                <pre id="stats-code">curl {{ url('/api/tickets/statistics') }}</pre>

                <h5 class="mt-5 mb-3">Тестовые аккаунты</h5>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Email</th>
                            <th>Пароль</th>
                            <th>Роль</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>manager@example.com</td>
                            <td>password</td>
                            <td><span class="badge bg-primary">manager</span></td>
                        </tr>
                        <tr>
                            <td>admin@example.com</td>
                            <td>password</td>
                            <td><span class="badge bg-danger">admin</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="/admin/tickets" class="btn btn-primary btn-sm">Открыть админ-панель →</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function copyCode(btn, elementId) {
        var text = document.getElementById(elementId).textContent;
        navigator.clipboard.writeText(text).then(function () {
            btn.textContent = 'Скопировано!';
            setTimeout(function () { btn.textContent = 'Копировать'; }, 2000);
        });
    }
    </script>
</body>
</html>
