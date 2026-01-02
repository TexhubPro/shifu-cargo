<div class="p-4 w-full min-w-70 max-w-52 flex flex-col justify-between h-full">
    <div class="space-y-1">
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}">
                <p
                    class="{{ Route::is('admin.dashboard') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M13.45 11.55l2.05 -2.05" />
                        <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                    </svg>
                    <span>{{ __('Панель управления') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.analitic') }}">
                <p
                    class="{{ Route::is('admin.analitic') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                        <path d="M9 17v-5" />
                        <path d="M12 17v-1" />
                        <path d="M15 17v-3" />
                    </svg>
                    <span>{{ __('Отчеты') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.china') }}">
                <p
                    class="{{ Route::is('admin.china') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M2 13.5v5.5l5 3" />
                        <path d="M7 16.545l5 -3.03" />
                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M12 19l5 3" />
                        <path d="M17 16.5l5 -3" />
                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                        <path d="M7 5.03v5.455" />
                        <path d="M12 8l5 -3" />
                    </svg>
                    <span>{{ __('Склад Хитой') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.dushanbe') }}">
                <p
                    class="{{ Route::is('admin.dushanbe') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                        <path d="M12 12l8 -4.5" />
                        <path d="M12 12l0 9" />
                        <path d="M12 12l-8 -4.5" />
                        <path d="M16 5.25l-8 4.5" />
                    </svg>
                    <span>{{ __('Склад Душанбе') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.register-pack') }}">
                <p
                    class="{{ Route::is('admin.register-pack') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M21 15h-2.5c-.398 0 -.779 .158 -1.061 .439c-.281 .281 -.439 .663 -.439 1.061c0 .398 .158 .779 .439 1.061c.281 .281 .663 .439 1.061 .439h1c.398 0 .779 .158 1.061 .439c.281 .281 .439 .663 .439 1.061c0 .398 -.158 .779 -.439 1.061c-.281 .281 -.663 .439 -1.061 .439h-2.5" />
                        <path d="M19 21v1m0 -8v1" />
                        <path
                            d="M13 21h-7c-.53 0 -1.039 -.211 -1.414 -.586c-.375 -.375 -.586 -.884 -.586 -1.414v-10c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h2m12 3.12v-1.12c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2" />
                        <path
                            d="M16 10v-6c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-4c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414v6m8 0h-8m8 0h1m-9 0h-1" />
                        <path d="M8 14v.01" />
                        <path d="M8 17v.01" />
                        <path d="M12 13.99v.01" />
                        <path d="M12 17v.01" />
                    </svg>
                    <span>{{ __('Регистрация груза') }}</span>
                </p>
            </a>
        @endif
        <a href="{{ route('admin.trackcodes') }}">
            <p
                class="{{ Route::is('admin.trackcodes') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                    <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                    <path d="M5 12l14 0" />
                </svg>
                <span>{{ __('Трек-коды') }}</span>
            </p>
        </a>
        <a href="{{ route('admin.customers') }}">
            <p
                class="{{ Route::is('admin.customers') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>
                <span>{{ __('Клиенты и коды') }}</span>
            </p>
        </a>
        <a href="{{ route('admin.applications') }}">
            <p
                class="{{ Route::is('admin.applications') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                    <path d="M3 9l4 0" />
                </svg>
                <span>{{ __('Заявки на доставку') }}</span>
            </p>
        </a>
        <a href="{{ route('admin.deliverers') }}">
            <p
                class="{{ Route::is('admin.deliverers') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                    <path d="M3 9l4 0" />
                </svg>
                <span>{{ __('Доставщики') }}</span>
            </p>
        </a>
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.smsbulk') }}">
                <p
                    class="{{ Route::is('admin.smsbulk') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 9h8" />
                        <path d="M8 13h6" />
                        <path d="M13 18l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6" />
                        <path d="M16 22l5 -5" />
                        <path d="M21 21.5v-4.5h-4.5" />
                    </svg>
                    <span>{{ __('СМС рассылка') }}</span>
                </p>
            </a>
        @endif
        <a href="{{ route('admin.chats') }}">
            <p
                class="{{ Route::is('admin.chats') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                </svg>
                <span>{{ __('Чат склиентами') }}</span>
            </p>
        </a>
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.expences') }}">
                <p
                    class="{{ Route::is('admin.expences') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h12.5" />
                        <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                        <path d="M19 21v1m0 -8v1" />
                    </svg>
                    <span>{{ __('Затраты') }}</span>
                </p>
            </a>
        @endif
        <a href="{{ route('admin.orders') }}">
            <p
                class="{{ Route::is('admin.orders') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 15l3 3l3 -3" />
                    <path d="M7 6v12" />
                    <path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" />
                    <path d="M17 14l-3.5 6h7z" />
                </svg>
                <span>{{ __('Заказы') }}</span>
            </p>
        </a>
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.faqs') }}">
                <p
                    class="{{ Route::is('admin.faqs') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M15 19l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                        <path d="M19 22v.01" />
                        <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                    </svg>
                    <span>{{ __('Частые вопросы') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.emplyones') }}">
                <p
                    class="{{ Route::is('admin.emplyones') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                        <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                        <path
                            d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                    </svg>
                    <span>{{ __('Сотрудники') }}</span>
                </p>
            </a>
            <a href="{{ route('admin.settings') }}">
                <p
                    class="{{ Route::is('admin.settings') ? 'text-blue-600' : 'text-gray-700 hover:bg-gray-200' }} min-w-full flex gap-3 items-center w-full text-base font-semibold p-3 hover:bg-gray-200 text-start rounded-xl duration-200">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                    <span>{{ __('Настройки Т-БОТ') }}</span>
                </p>
            </a>
        @endif
    </div>
</div>
