<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Затраты</flux:heading>

            <div class="flex items-center gap-2">
                <flux:modal.trigger name="edit-profile">
                    <flux:button variant="primary" color="lime">Добавить</flux:button>
                </flux:modal.trigger>

                <flux:modal.trigger name="expences-filters">
                    <flux:button variant="primary" color="lime" square size="base" class="shrink-0 !text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-adjustments">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M6 3a1 1 0 0 1 .993 .883l.007 .117v3.171a3.001 3.001 0 0 1 0 5.658v7.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-7.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-3.17a1 1 0 0 1 1 -1z" />
                            <path
                                d="M12 3a1 1 0 0 1 .993 .883l.007 .117v9.171a3.001 3.001 0 0 1 0 5.658v1.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-1.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-9.17a1 1 0 0 1 1 -1z" />
                            <path
                                d="M18 3a1 1 0 0 1 .993 .883l.007 .117v.171a3.001 3.001 0 0 1 0 5.658v10.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-10.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-.17a1 1 0 0 1 1 -1z" />
                        </svg>
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>

    <flux:modal name="expences-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры затрат</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:input icon="magnifying-glass" placeholder="Сумма или описание" clearable label="Поиск"
                    wire:model.defer="search" />
                <flux:select label="Склад" wire:model.defer="warehouseFilter" placeholder="Все склады">
                    <flux:select.option value="">Все склады</flux:select.option>
                    <flux:select.option value="Склад Душанбе">Склад Душанбе</flux:select.option>
                    <flux:select.option value="Склад Иву">Склад Иву</flux:select.option>
                    <flux:select.option value="Кубатура Иву">Кубатура Иву</flux:select.option>
                    <flux:select.option value="Кубатура Душанбе">Кубатура Душанбе</flux:select.option>
                </flux:select>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:date-picker label="Дата от" wire:model.defer="dateFrom" />
                    <flux:date-picker label="Дата до" wire:model.defer="dateTo" />
                </div>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="total">По сумме</flux:select.option>
                    <flux:select.option value="sklad">По складу</flux:select.option>
                    <flux:select.option value="data">По дате расхода</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>

                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="applyFilters">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        @php
            $summary = $this->expensesSummary;
            $daily = $this->expensesDaily;
            $categories = $this->expensesByCategory['items'] ?? [];
            $statsRangeLabel = $this->statsRange['label'] ?? 'Период';
            $dailyTotals = $daily['totals'] ?? [];
            $dailyLabels = $daily['labels'] ?? [];
            $maxDaily = max(1, $daily['max'] ?? 0);
            $categoryMax = 0;
            foreach ($categories as $item) {
                $categoryMax = max($categoryMax, $item['total'] ?? 0);
            }
            $categoryMax = max(1, $categoryMax);
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Общий обзор затрат</p>
                        <p class="text-xs text-slate-400">{{ $statsRangeLabel }}</p>
                    </div>
                    <span class="text-[11px] text-slate-500 bg-white px-3 py-1 rounded-full">аналитика</span>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                        <div class="text-xs text-slate-400">Итого</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">
                            {{ number_format($summary['total'] ?? 0, 0, '.', ' ') }} с
                        </div>
                    </div>
                    <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                        <div class="text-xs text-slate-400">Средняя запись</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">
                            {{ number_format($summary['average'] ?? 0, 0, '.', ' ') }} с
                        </div>
                    </div>
                    <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                        <div class="text-xs text-slate-400">Максимум</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">
                            {{ number_format($summary['max'] ?? 0, 0, '.', ' ') }} с
                        </div>
                    </div>
                    <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                        <div class="text-xs text-slate-400">Записей</div>
                        <div class="mt-2 text-lg font-semibold text-slate-900">{{ $summary['count'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Динамика затрат</p>
                        <p class="text-xs text-gray-400">По дням</p>
                    </div>
                    <span class="text-xs text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                        {{ number_format(array_sum($dailyTotals), 0, '.', ' ') }} с
                    </span>
                </div>
                <div class="mt-4">
                    @php
                        $width = 480;
                        $height = 180;
                        $padding = 16;
                        $count = count($dailyTotals);
                        $gap = 6;
                        $barWidth = $count > 0 ? max(2, ($width - 2 * $padding - ($count - 1) * $gap) / $count) : 0;
                    @endphp
                    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-44">
                        <defs>
                            <linearGradient id="expenseBars" x1="0" y1="0" x2="0"
                                y2="1">
                                <stop offset="0%" stop-color="#0ea5e9" stop-opacity="0.9" />
                                <stop offset="100%" stop-color="#0ea5e9" stop-opacity="0.25" />
                            </linearGradient>
                        </defs>
                        <g>
                            @for ($i = 0; $i < $count; $i++)
                                @php
                                    $value = (float) ($dailyTotals[$i] ?? 0);
                                    $barHeight = ($value / $maxDaily) * ($height - 2 * $padding);
                                    $x = $padding + $i * ($barWidth + $gap);
                                    $y = $height - $padding - $barHeight;
                                @endphp
                                <rect x="{{ $x }}" y="{{ $y }}" width="{{ $barWidth }}"
                                    height="{{ $barHeight }}" rx="6" fill="url(#expenseBars)" />
                            @endfor
                        </g>
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-400 flex justify-between">
                    <span>{{ $dailyLabels[0] ?? '' }}</span>
                    <span>{{ \Illuminate\Support\Arr::last($dailyLabels) ?? '' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Категории затрат</p>
                        <p class="text-xs text-gray-400">Топ по сумме</p>
                    </div>
                    <span class="text-xs text-slate-500 bg-slate-50 px-3 py-1 rounded-full">топ 6</span>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($categories as $item)
                        @php
                            $label = $item['label'] ?? '-';
                            $value = $item['total'] ?? 0;
                            $width = max(6, round(($value / $categoryMax) * 100));
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span class="truncate">{{ $label }}</span>
                                <span>{{ number_format($value, 0, '.', ' ') }} с</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-amber-500" style="width: {{ $width }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400">Нет данных для анализа.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <flux:table :paginate="$this->expences">
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
                <flux:table.column>Склад/Кубатура</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->expences as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->total }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->content }}</flux:table.cell>
                        <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->data }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <div class="flex items-center justify-end">
                                    <flux:modal.trigger name="confirm-expense-delete">
                                        <flux:button variant="danger" size="sm" square icon="trash"
                                            icon:class="!text-white" class="!text-white"
                                            wire:click="confirmDelete({{ $item->id }})" />
                                    </flux:modal.trigger>
                                </div>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:modal name="confirm-expense-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить затрату?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($expenseToDeleteContent)
                            Будет удалена запись <span class="font-semibold">{{ $expenseToDeleteContent }}</span>
                            @if ($expenseToDeleteTotal !== null)
                                на сумму <span
                                    class="font-semibold">{{ number_format((float) $expenseToDeleteTotal, 2, '.', ' ') }}
                                    c</span>.
                            @endif
                        @endif
                        Это действие нельзя отменить.
                    </flux:text>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost" wire:click="clearDeleteSelection">Отмена</flux:button>
                </flux:modal.close>

                <flux:modal.close>
                    <flux:button variant="danger" icon="trash" wire:click="deleteSelected"
                        :disabled="$expenseToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="edit-profile" class="md:w-96">
        <form wire:submit="addExpense" class="space-y-6">
            <div>
                <flux:heading size="lg">Добавление затрат</flux:heading>
                <flux:text class="mt-2">
                    Заполните поля, чтобы добавить новую запись о расходах, указав склад, сумму и описание затрат.
                </flux:text>
            </div>
            <flux:date-picker label="Выберите дата" wire:model="data" required />
            <flux:select label="Склад" placeholder="Выберите склад" required wire:model.live="warehouse">
                <flux:select.option value="Склад Душанбе">Склад Душанбе</flux:select.option>
                <flux:select.option value="Склад Иву">Склад Иву</flux:select.option>
                <flux:select.option value="Кубатура Иву">Кубатура Иву</flux:select.option>
                <flux:select.option value="Кубатура Душанбе">Кубатура Душанбе</flux:select.option>
            </flux:select>

            @if ($hidden == false)
                @if ($warehouse === 'Склад Иву')
                    <flux:select label="Статья затрат" placeholder="Выберите статью" required
                        wire:model.live="expenseCategory">
                        <flux:select.option value="Сумма доставки Иву–Кашкар">Сумма доставки Иву–Кашкар
                        </flux:select.option>
                        <flux:select.option value="Сумма доставки Иву–Урумчи">Сумма доставки Иву–Урумчи
                        </flux:select.option>
                        <flux:select.option value="Сумма скотча Иву">Сумма скотча Иву</flux:select.option>
                        <flux:select.option value="Сумма коробок склад Иву">Сумма коробок склад Иву
                        </flux:select.option>
                        <flux:select.option value="Сумма зарплаты склад Иву">Сумма зарплаты склад Иву
                        </flux:select.option>
                        <flux:select.option value="Сумма допрасходов Иву">Сумма допрасходов Иву
                        </flux:select.option>
                    </flux:select>
                @elseif ($warehouse === 'Склад Душанбе')
                    <flux:select label="Статья затрат" placeholder="Выберите статью" required
                        wire:model.live="expenseCategory">
                        <flux:select.option value="Склад Душанбе — налог">Склад Душанбе — налог</flux:select.option>
                        <flux:select.option value="Склад Душанбе — зарплата">Склад Душанбе — зарплата
                        </flux:select.option>
                        <flux:select.option value="Склад Душанбе — обед/ужин">Склад Душанбе — обед/ужин
                        </flux:select.option>
                        <flux:select.option value="Склад Душанбе — возврат груза">Склад Душанбе — возврат груза
                        </flux:select.option>
                        <flux:select.option value="Склад Душанбе — участковый">Склад Душанбе — участковый
                        </flux:select.option>
                        <flux:select.option value="Склад Душанбе — допрасходы">Склад Душанбе — допрасходы
                        </flux:select.option>
                    </flux:select>
                @else
                    <flux:textarea label="Описание" placeholder="Введите описание затрат" wire:model="description" />
                @endif

                @if (\Illuminate\Support\Str::contains($expenseCategory, 'зарплата'))
                    <flux:input label="Имя сотрудника" placeholder="Введите имя (необязательно)"
                        wire:model.live="employeeName" />
                @endif
            @endif

            @if ($hidden == true)
                <flux:input type="text" inputmode="decimal" label="Курс доллара" placeholder="Введите курс"
                    required wire:model.lazy="dollarRate" />
                <flux:text class="text-xs text-gray-500">
                    Сумма в USD будет автоматически пересчитана в сомони по указанному курсу.
                </flux:text>
            @endif

            <!-- Сумма -->
            <flux:input type="number" label="{{ $hidden ? 'Сумма (USD)' : 'Сумма' }}" placeholder="Введите сумму"
                required wire:model="amount" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Добавить затраты
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
