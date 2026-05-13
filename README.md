# Mini CRM — виджет заявок

**Стек:** Laravel 12, PHP 8.4, MySQL 8.0, Docker

---

## Быстрый старт

### 1. Запуск одной командой

```bash
docker compose up -d --build
```

Entrypoint автоматически выполнит `migrate`, `db:seed` и `storage:link` при первом старте.

### 2. Если запускаете повторно с нуля

```bash
docker compose down -v        # удалить контейнеры и volume с БД
docker compose up -d --build  # пересобрать и запустить
```

---

## URL после запуска

| URL | Описание |
|---|---|
| http://localhost:8080 | Главная (редирект на админ-панель) |
| http://localhost:8080/login | Форма входа |
| http://localhost:8080/admin/tickets | Список заявок (требует авторизации) |
| http://localhost:8080/widget | Виджет обратной связи (iframe) |
| http://localhost:8080/widget-demo | Тестовая страница виджета |
| http://localhost:8080/api/tickets | POST — создание заявки |
| http://localhost:8080/api/tickets/statistics | GET — статистика |

---

## Тестовые аккаунты

| Email | Пароль | Роль |
|---|---|---|
| manager@example.com | password | manager |
| admin@example.com | password | admin |

---

## Вставка виджета на сторонний сайт

```html
<iframe
  src="https://your-domain.com/widget"
  width="500"
  height="620"
  frameborder="0"
  style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1);"
  title="Форма обратной связи"
></iframe>
```

---

## API

### POST /api/tickets — создание заявки

```bash
curl -X POST http://localhost:8080/api/tickets \
  -F "name=Иван Иванов" \
  -F "phone=+380991234567" \
  -F "email=ivan@example.com" \
  -F "subject=Нужна консультация" \
  -F "body=Хочу узнать о ваших услугах" \
  -F "files[]=@/path/to/file.pdf"
```

**Успешный ответ (201):**
```json
{
  "data": {
    "id": 1,
    "subject": "Нужна консультация",
    "body": "Хочу узнать о ваших услугах",
    "status": "new",
    "replied_at": null,
    "created_at": "2026-05-13T12:00:00.000000Z",
    "customer": {
      "id": 1,
      "name": "Иван Иванов",
      "phone": "+380991234567",
      "email": "ivan@example.com"
    },
    "files": []
  }
}
```

**Ошибка лимита (1 заявка в сутки):**
```json
{
  "message": "Вы уже отправляли заявку сегодня. Повторная отправка возможна через 24 часа."
}
```

### GET /api/tickets/statistics — статистика

```bash
curl http://localhost:8080/api/tickets/statistics
```

**Ответ (200):**
```json
{
  "data": {
    "today": 5,
    "week": 32,
    "month": 128,
    "by_status": {
      "new": 45,
      "in_progress": 23,
      "resolved": 60
    }
  }
}
```

---

## Пакеты

- `spatie/laravel-permission` — роли `admin` и `manager`
- `spatie/laravel-medialibrary` — файлы к заявкам (коллекция `attachments`)
