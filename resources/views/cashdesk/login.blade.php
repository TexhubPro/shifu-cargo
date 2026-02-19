<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cashdesk Login</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/favicon_color.svg') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-neutral-950 text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-2xl border border-neutral-800 bg-neutral-900 p-6 space-y-4">
        <div class="space-y-1">
            <h1 class="text-xl font-semibold">Вход в Cashdesk API</h1>
            <p class="text-sm text-neutral-400">Вход по телефону и паролю, получение токена для кассы.</p>
        </div>

        <form id="cashdesk-login-form" class="space-y-3">
            <label class="block space-y-1">
                <span class="text-sm text-neutral-300">Телефон</span>
                <input id="phone" name="phone" type="text" required
                    class="w-full rounded-lg border border-neutral-700 bg-neutral-950 px-3 py-2 outline-none focus:border-lime-500"
                    placeholder="Введите номер телефона">
            </label>

            <label class="block space-y-1">
                <span class="text-sm text-neutral-300">Пароль</span>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-lg border border-neutral-700 bg-neutral-950 px-3 py-2 outline-none focus:border-lime-500"
                    placeholder="Введите пароль">
            </label>

            <label class="flex items-center gap-2 text-sm text-neutral-300">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-neutral-600">
                Запомнить меня
            </label>

            <button type="submit"
                class="w-full rounded-lg bg-lime-600 hover:bg-lime-500 px-3 py-2 font-medium text-black">
                Войти и получить токен
            </button>
        </form>

        <p id="status-message" class="text-sm text-neutral-300"></p>

        <div id="token-box" class="hidden space-y-2 rounded-lg border border-neutral-700 bg-neutral-950 p-3">
            <p class="text-sm text-neutral-300">Токен:</p>
            <textarea id="token-field" rows="4" readonly
                class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-2 py-2 text-xs text-lime-300"></textarea>
            <button id="copy-token-btn" type="button"
                class="rounded-lg border border-neutral-600 px-3 py-1.5 text-sm hover:bg-neutral-800">
                Копировать токен
            </button>
        </div>
    </div>

    <script>
        (() => {
            const form = document.getElementById('cashdesk-login-form');
            const phone = document.getElementById('phone');
            const password = document.getElementById('password');
            const remember = document.getElementById('remember');
            const statusMessage = document.getElementById('status-message');
            const tokenBox = document.getElementById('token-box');
            const tokenField = document.getElementById('token-field');
            const copyTokenBtn = document.getElementById('copy-token-btn');

            const TOKEN_KEY = 'cashdesk_access_token';
            const USER_KEY = 'cashdesk_user';

            const setStatus = (message, isError = false) => {
                statusMessage.textContent = message;
                statusMessage.classList.toggle('text-red-400', isError);
                statusMessage.classList.toggle('text-neutral-300', !isError);
            };

            const persistToken = (token, user, shouldRemember) => {
                window.localStorage.removeItem(TOKEN_KEY);
                window.localStorage.removeItem(USER_KEY);
                window.sessionStorage.removeItem(TOKEN_KEY);
                window.sessionStorage.removeItem(USER_KEY);

                const storage = shouldRemember ? window.localStorage : window.sessionStorage;
                storage.setItem(TOKEN_KEY, token);
                storage.setItem(USER_KEY, JSON.stringify(user));
            };

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                setStatus('Выполняется вход...');
                tokenBox.classList.add('hidden');

                try {
                    const response = await fetch('/api/cashdesk/auth/login', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            phone: phone.value.trim(),
                            password: password.value,
                            remember: remember.checked,
                            device_name: 'cashdesk-web-login',
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const message = data.message || 'Ошибка авторизации.';
                        setStatus(message, true);
                        return;
                    }

                    persistToken(data.token, data.user, remember.checked);
                    tokenField.value = data.token;
                    tokenBox.classList.remove('hidden');
                    setStatus('Успешный вход. Токен сохранен.');
                } catch (error) {
                    setStatus('Не удалось выполнить вход. Проверьте соединение.', true);
                }
            });

            copyTokenBtn.addEventListener('click', async () => {
                if (!tokenField.value) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(tokenField.value);
                    setStatus('Токен скопирован в буфер обмена.');
                } catch (error) {
                    setStatus('Не удалось скопировать токен.', true);
                }
            });
        })();
    </script>
</body>

</html>
