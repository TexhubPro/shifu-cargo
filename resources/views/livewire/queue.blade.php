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
            padding: 40px 5vw 60px;
            display: flex;
            align-items: center;
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
            max-width: 1400px;
            background: rgba(4, 7, 19, 0.85);
            border-radius: 32px;
            border: 1px solid var(--border);
            box-shadow: 0 40px 120px rgba(4, 7, 19, 0.85);
            backdrop-filter: blur(18px);
            padding: 40px 40px 50px;
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
            padding: 22px 36px;
            border-radius: 24px;
            background: linear-gradient(120deg, #96ff6f, #33ffa9);
            color: #04121d;
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-align: center;
            min-width: 320px;
            box-shadow: 0 20px 60px rgba(150, 255, 111, 0.45);
        }

        .stats {
            margin: 50px 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .stat-card {
            padding: 24px;
            border-radius: 22px;
            background: var(--glass);
            border: 1px solid var(--border);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.03);
        }

        .stat-label {
            font-size: 0.95rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
        }

        .stat-value {
            margin-top: 10px;
            font-size: 2.6rem;
            font-weight: 800;
            color: #fdfdfd;
        }

        .columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
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
            display: flex;
            flex-direction: column;
            gap: 18px;
            max-height: 55vh;
            overflow-y: auto;
            padding-right: 8px;
        }

        .queue-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px 22px;
            border-radius: 18px;
            background: rgba(3, 7, 18, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 20px rgba(4, 7, 19, 0.6);
        }

        .queue-card.is-active {
            border-color: rgba(163, 255, 120, 0.7);
            box-shadow: 0 12px 35px rgba(163, 255, 120, 0.25);
            background: rgba(12, 23, 15, 0.65);
        }

        .queue-number {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--accent);
        }

        .queue-name {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .queue-note {
            font-size: 0.9rem;
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
                padding: 30px 20px 40px;
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
            <div class="stat-card">
                <div class="stat-label">Всего в очереди</div>
                <div class="stat-value">{{ $navbats?->count() ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Мужчины</div>
                <div class="stat-value">{{ $men->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Женщины</div>
                <div class="stat-value">{{ $women->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">На кассе сейчас</div>
                <div class="stat-value">{{ $activeCount }}</div>
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
