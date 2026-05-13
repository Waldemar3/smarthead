<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1a1a2e;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 4px;
            color: #555;
        }

        label .req {
            color: #e53e3e;
            margin-left: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            background: #fff;
            transition: border-color 0.2s;
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: #4361ee;
        }

        input.error, textarea.error {
            border-color: #e53e3e;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .error-msg {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 3px;
            display: none;
        }

        .error-msg.visible {
            display: block;
        }

        .file-hint {
            font-size: 11px;
            color: #888;
            margin-top: 3px;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: #4361ee;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 4px;
        }

        .btn-submit:hover:not(:disabled) {
            background: #3451d1;
        }

        .btn-submit:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
        }

        .alert-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #276749;
        }

        .success-block {
            text-align: center;
            padding: 32px 16px;
        }

        .success-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .success-block h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #276749;
        }

        .success-block p {
            color: #555;
            font-size: 13px;
        }

        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 6px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="widget-form-wrap">
        <h2>Обратная связь</h2>

        <div id="alert-global" class="alert alert-error" style="display:none;"></div>

        <form id="widget-form" novalidate>
            <div class="form-group">
                <label>Имя <span class="req">*</span></label>
                <input type="text" name="name" placeholder="Ваше имя">
                <div class="error-msg" data-field="name"></div>
            </div>

            <div class="form-group">
                <label>Телефон <span class="req">*</span></label>
                <input type="tel" name="phone" placeholder="+380991234567">
                <div class="error-msg" data-field="phone"></div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@example.com">
                <div class="error-msg" data-field="email"></div>
            </div>

            <div class="form-group">
                <label>Тема <span class="req">*</span></label>
                <input type="text" name="subject" placeholder="Тема обращения">
                <div class="error-msg" data-field="subject"></div>
            </div>

            <div class="form-group">
                <label>Сообщение <span class="req">*</span></label>
                <textarea name="body" placeholder="Опишите ваш вопрос..."></textarea>
                <div class="error-msg" data-field="body"></div>
            </div>

            <div class="form-group">
                <label>Файлы</label>
                <input type="file" name="files[]" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.zip">
                <div class="file-hint">До 5 файлов, макс. 10 МБ каждый</div>
                <div class="error-msg" data-field="files"></div>
            </div>

            <button type="submit" class="btn-submit" id="btn-submit">Отправить</button>
        </form>
    </div>

    <div id="widget-success" class="success-block" style="display:none;">
        <div class="success-icon">✅</div>
        <h3>Заявка принята!</h3>
        <p>Мы свяжемся с вами в ближайшее время.</p>
    </div>

    <script>
    (function () {
        var form = document.getElementById('widget-form');
        var btn = document.getElementById('btn-submit');
        var alertGlobal = document.getElementById('alert-global');
        var successBlock = document.getElementById('widget-success');
        var formWrap = document.getElementById('widget-form-wrap');

        function clearErrors() {
            form.querySelectorAll('input, textarea').forEach(function (el) {
                el.classList.remove('error');
            });
            form.querySelectorAll('.error-msg').forEach(function (el) {
                el.textContent = '';
                el.classList.remove('visible');
            });
            hideAlert();
        }

        function showFieldError(field, msg) {
            var input = form.querySelector('[name="' + field + '"]');
            if (input) input.classList.add('error');
            var errEl = form.querySelector('[data-field="' + field + '"]');
            if (errEl) {
                errEl.textContent = msg;
                errEl.classList.add('visible');
            }
        }

        function showAlert(msg) {
            alertGlobal.textContent = msg;
            alertGlobal.style.display = 'block';
        }

        function hideAlert() {
            alertGlobal.style.display = 'none';
        }

        function setLoading(loading) {
            btn.disabled = loading;
            btn.innerHTML = loading
                ? '<span class="spinner"></span>Отправка...'
                : 'Отправить';
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrors();
            setLoading(true);

            var data = new FormData(form);

            fetch('/api/tickets', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: data
            })
            .then(function (res) {
                return res.json().then(function (json) {
                    return { status: res.status, body: json };
                });
            })
            .then(function (result) {
                if (result.status === 201) {
                    formWrap.style.display = 'none';
                    successBlock.style.display = 'block';
                    return;
                }

                if (result.status === 422) {
                    var body = result.body;
                    if (body.errors) {
                        Object.keys(body.errors).forEach(function (field) {
                            showFieldError(field, body.errors[field][0]);
                        });
                    } else if (body.message) {
                        showAlert(body.message);
                    }
                    return;
                }

                showAlert('Произошла ошибка. Попробуйте позже.');
            })
            .catch(function () {
                showAlert('Ошибка сети. Проверьте подключение и попробуйте снова.');
            })
            .finally(function () {
                setLoading(false);
            });
        });
    })();
    </script>
</body>
</html>
