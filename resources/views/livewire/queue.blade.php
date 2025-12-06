<div class="queue-screen" wire:poll.15s="updateData">
    @php
        $men = $navbats?->where('sex', 'm') ?? collect();
        $women = $navbats?->where('sex', 'z') ?? collect();
        $activeCount = $navbats?->where('status', 'Касса')->count() ?? 0;
    @endphp
    <style>
        :root {
            --bg-dark: #05070f;
            --glass: rgba(255, 255, 255, 0.06);
            --border: rgba(255, 255, 255, 0.18);
            --men-gradient: linear-gradient(135deg, #0072ff, #00c6ff);
            --women-gradient: linear-gradient(135deg, #ff4d79, #ff9068);
            --accent: #a3ff78;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            background: var(--bg-dark);
            color: #f4f4f8;
        }

        .queue-screen {
            position: relative;
            min-height: 100vh;
            width: 100%;
            padding: 0;
            display: flex;
            align-items: stretch;
            justify-content: center;
            overflow: hidden;
        }

        .queue-screen::before,
        .queue-screen::after {
            content: '';
            position: absolute;
            width: 60vw;
            height: 60vw;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
        }

        .queue-screen::before {
            background: #4c69ff;
            top: -20%;
            left: -10%;
        }

        .queue-screen::after {
            background: #ff4d79;
            bottom: -30%;
            right: -15%;
        }

        .queue-shell {
            position: relative;
            z-index: 1;
            width: 100%;
            min-height: 100vh;
            background: rgba(4, 7, 19, 0.9);
            border-radius: 0;
            border: none;
            backdrop-filter: blur(18px);
            padding: 60px 6vw 80px;
        }

        .hero {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #f9f9ff;
        }

        .hero-caption {
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 1rem;
        }

        .code-pill {
            padding: 18px 32px;
            border-radius: 24px;
            background: linear-gradient(120deg, #96ff6f, #33ffa9);
            color: #04121d;
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-align: center;
            min-width: 280px;
        }

        .stats {
            margin: 60px 0 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 26px 28px;
            border-radius: 28px;
            background: var(--glass);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.35;
            pointer-events: none;
        }

        .stat-card.stat-total::after {
            background: linear-gradient(120deg, rgba(150, 255, 111, 0.4), rgba(51, 255, 169, 0.1));
        }

        .stat-card.stat-men::after {
            background: linear-gradient(120deg, rgba(0, 114, 255, 0.35), rgba(0, 198, 255, 0.12));
        }

        .stat-card.stat-women::after {
            background: linear-gradient(120deg, rgba(255, 77, 121, 0.35), rgba(255, 144, 104, 0.12));
        }

        .stat-card.stat-active::after {
            background: linear-gradient(120deg, rgba(255, 214, 102, 0.35), rgba(252, 219, 70, 0.15));
        }

        .stat-card>* {
            position: relative;
            z-index: 1;
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 28px;
            height: 28px;
            fill: #f4f4f4;
        }

        .stat-copy {
            flex: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
        }

        .stat-value {
            margin-top: 4px;
            font-size: 2.4rem;
            font-weight: 800;
            color: #fdfdfd;
        }

        .stat-hint {
            margin-top: 6px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.55);
        }

        .columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 40px;
        }

        .lane {
            border-radius: 26px;
            padding: 26px;
            background: var(--glass);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .lane::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.15;
            z-index: 0;
        }

        .lane-men::before {
            background: var(--men-gradient);
        }

        .lane-women::before {
            background: var(--women-gradient);
        }

        .lane-header {
            position: relative;
            z-index: 1;
            margin-bottom: 24px;
        }

        .lane-title {
            font-size: 1.4rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-weight: 700;
            margin: 0;
        }

        .lane-subtitle {
            margin-top: 6px;
            color: rgba(255, 255, 255, 0.65);
            letter-spacing: 0.08em;
        }

        .queue-list {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            max-height: calc(100vh - 320px);
            overflow-y: auto;
            padding-right: 4px;
        }

        .queue-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            min-height: 82px;
            border-radius: 14px;
            background: rgba(3, 7, 18, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .queue-card.is-active {
            border-color: rgba(163, 255, 120, 0.7);
            background: rgba(12, 23, 15, 0.65);
        }

        .queue-number {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--accent);
        }

        .queue-name {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .queue-note {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 4px;
        }

        .empty-state {
            padding: 24px;
            border-radius: 18px;
            border: 1px dashed rgba(255, 255, 255, 0.3);
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 768px) {
            .queue-shell {
                padding: 40px 20px 60px;
            }

            .hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .code-pill {
                width: 100%;
                font-size: 2.4rem;
                letter-spacing: 0.15em;
                min-width: 0;
            }

            .queue-list {
                max-height: none;
            }
        }
    </style>

    <div class="queue-shell">
        <div class="hero">
            <div>
                <div class="hero-title">Очередь обслуживания</div>
                <div class="hero-caption">Автообновление каждые 15 секунд · актуальный код подтверждения</div>
            </div>
            <div class="code-pill">#{{ $code->content }}</div>
        </div>

        <div class="stats">
            <div class="stat-card stat-total">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M7 12a5 5 0 1 1 5.001-5A5 5 0 0 1 7 12zm10 0a5 5 0 1 0-5.001-5A5 5 0 0 0 17 12zm0 2a6.994 6.994 0 0 0-5 2.101 6.994 6.994 0 0 0-5-2.101A7 7 0 0 0 0 21v1h24v-1a7 7 0 0 0-7-7z" />
                    </svg>
                </div>
                <div class="stat-copy">
                    <div class="stat-label">Всего в очереди</div>
                    <div class="stat-value">{{ $navbats?->count() ?? 0 }}</div>
                    <div class="stat-hint">Записано сегодня</div>
                </div>
            </div>
            <div class="stat-card stat-men">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M16 2v5h-2.586l-1.707 1.707A5.001 5.001 0 0 0 7 16a5 5 0 1 0 4.293-7.707L13 7.586V5h5V2z" />
                    </svg>
                </div>
                <div class="stat-copy">
                    <div class="stat-label">Мужчины</div>
                    <div class="stat-value">{{ $men->count() }}</div>
                    <div class="stat-hint">Ожидают вызова</div>
                </div>
            </div>
            <div class="stat-card stat-women">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2a6 6 0 0 0-2 11.674V16H7v2h3v4h2v-4h3v-2h-3v-2.326A6 6 0 0 0 12 2zm0 2a4 4 0 1 1-4 4 4 4 0 0 1 4-4z" />
                    </svg>
                </div>
                <div class="stat-copy">
                    <div class="stat-label">Женщины</div>
                    <div class="stat-value">{{ $women->count() }}</div>
                    <div class="stat-hint">Ожидают вызова</div>
                </div>
            </div>
            <div class="stat-card stat-active">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 3a9 9 0 1 0 9 9h-2a7 7 0 1 1-7-7V3zm1 0v10l5.5 3.3 1-1.732L14 12.268V3z" />
                    </svg>
                </div>
                <div class="stat-copy">
                    <div class="stat-label">На кассе сейчас</div>
                    <div class="stat-value">{{ $activeCount }}</div>
                    <div class="stat-hint">Помечены статусом «Касса»</div>
                </div>
            </div>
        </div>

        <div class="columns">
            <section class="lane lane-men">
                <div class="lane-header">
                    <p class="lane-title">Мужчины</p>
                    <p class="lane-subtitle">номер · имя</p>
                </div>
                <div class="queue-list">
                    @forelse ($men as $item)
                        <div class="queue-card {{ $item->status === 'Касса' ? 'is-active' : '' }}">
                            <div>
                                <div class="queue-number">№{{ str_pad($item->no, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="queue-name">{{ $item->user->name ?? 'Без имени' }}</div>
                                <div class="queue-note">
                                    {{ $item->status === 'Касса' ? 'Подходит к кассе' : 'Ожидание подключения' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Мужская очередь пуста.</div>
                    @endforelse
                </div>
            </section>

            <section class="lane lane-women">
                <div class="lane-header">
                    <p class="lane-title">Женщины</p>
                    <p class="lane-subtitle">номер · имя</p>
                </div>
                <div class="queue-list">
                    @forelse ($women as $item)
                        <div class="queue-card {{ $item->status === 'Касса' ? 'is-active' : '' }}">
                            <div>
                                <div class="queue-number">№{{ str_pad($item->no, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="queue-name">{{ $item->user->name ?? 'Без имени' }}</div>
                                <div class="queue-note">
                                    {{ $item->status === 'Касса' ? 'Подходит к кассе' : 'Ожидание подключения' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Женская очередь пуста.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
