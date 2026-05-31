<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Progreso de Lectura</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8fafc; color: #222; margin: 0; }
        .header { background: #2563eb; color: #fff; padding: 2rem 1rem 1rem 1rem; box-shadow: 0 2px 8px #0001; }
        .header h1 { margin: 0 0 0.5rem 0; font-size: 2rem; }
        .header .meta { font-size: 1rem; margin-bottom: 0.5rem; }
        .header .filters-applied { font-size: 0.95rem; color: #d1fae5; }
        .filters { display: flex; align-items: flex-end; gap: 1rem; background: #fff; padding: 1rem; box-shadow: 0 2px 8px #0001; margin-bottom: 1.5rem; }
        .filters label { font-weight: 500; margin-right: 0.5rem; }
        .filters select, .filters button { padding: 0.4rem 0.7rem; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 1rem; }
        .filters .print-btn { background: #22c55e; color: #fff; border: none; margin-left: auto; cursor: pointer; font-weight: 600; transition: background 0.2s; }
        .filters .print-btn:hover { background: #16a34a; }
        .stats { display: flex; gap: 1.5rem; margin: 0 0 1.5rem 0; justify-content: center; }
        .stat-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 1rem 2rem; text-align: center; min-width: 120px; }
        .stat-card .label { font-size: 0.95rem; color: #64748b; }
        .stat-card .value { font-size: 1.5rem; font-weight: 700; margin-top: 0.2rem; }
        .table-wrap { overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; background: #fff; box-shadow: 0 2px 8px #0001; }
        th, td { padding: 0.7rem 1rem; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f1f5f9; font-weight: 600; }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: 0.2em 0.8em; border-radius: 999px; font-size: 0.95em; font-weight: 600; color: #fff; }
        .badge.reading { background: #2563eb; }
        .badge.completed { background: #22c55e; }
        .badge.want_to_read { background: #f59e42; }
        .progress-bar { background: #e5e7eb; border-radius: 6px; height: 10px; width: 100px; display: inline-block; vertical-align: middle; margin-left: 0.5em; }
        .progress-bar-inner { background: #2563eb; height: 100%; border-radius: 6px; }
        .footer { text-align: center; color: #64748b; font-size: 0.95rem; margin: 2rem 0 1rem 0; }
        @media print {
            body { background: #fff !important; color: #000; }
            .no-print { display: none !important; }
            .header, .footer, th, .badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .header, .footer { box-shadow: none !important; }
            .table-wrap, table { box-shadow: none !important; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Gestor de Lectura</h1>
        <div class="meta">
            <span>Reporte de Progreso de Lectura</span> &mdash;
            <span>{{ now()->format('d/m/Y H:i') }}</span> &mdash;
            <span>Usuario: {{ $user->name }}</span>
        </div>
        @if($filters['status'] || $filters['genre'])
            <div class="filters-applied">
                Filtros aplicados:
                @if($filters['status'])
                    <span>Status: <b>{{ ucfirst(str_replace('_', ' ', $filters['status'])) }}</b></span>
                @endif
                @if($filters['genre'])
                    <span>Género: <b>{{ $filters['genre'] }}</b></span>
                @endif
            </div>
        @endif
    </div>
    <form class="filters no-print" method="GET" action="{{ route('report.index') }}">
        <div>
            <label for="status">Estado:</label>
            <select name="status" id="status">
                <option value="">Todos</option>
                <option value="want_to_read" @selected($filters['status'] === 'want_to_read')>Por leer</option>
                <option value="reading" @selected($filters['status'] === 'reading')>Leyendo</option>
                <option value="completed" @selected($filters['status'] === 'completed')>Completado</option>
            </select>
        </div>
        <div>
            <label for="genre">Género:</label>
            <select name="genre" id="genre">
                <option value="">Todos</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" @selected($filters['genre'] === $genre)> {{ $genre }} </option>
                @endforeach
            </select>
        </div>
        <button type="submit">Filtrar</button>
        <button type="button" class="print-btn" onclick="window.print()">Imprimir Reporte</button>
    </form>
    <div class="stats">
        @php
            $total = $records->count();
            $reading = $records->where('status', 'reading')->count();
            $completed = $records->where('status', 'completed')->count();
            $want = $records->where('status', 'want_to_read')->count();
        @endphp
        <div class="stat-card">
            <div class="label">Total</div>
            <div class="value">{{ $total }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Leyendo</div>
            <div class="value">{{ $reading }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Completado</div>
            <div class="value">{{ $completed }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Por leer</div>
            <div class="value">{{ $want }}</div>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Progreso</th>
                    <th>Estado</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    @if($isAdmin)
                        <th>Usuario</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $rec)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $rec->book->title ?? '-' }}</td>
                        <td>{{ $rec->book->author ?? '-' }}</td>
                        <td>{{ $rec->book->genre ?? '-' }}</td>
                        <td>
                            {{ $rec->current_page }} / {{ $rec->book->total_pages ?? '-' }}
                            @if($rec->book && $rec->book->total_pages)
                                @php $pct = min(100, round($rec->current_page / max(1, $rec->book->total_pages) * 100)); @endphp
                                <span class="progress-bar"><span class="progress-bar-inner" style="width: {{ $pct }}%;"></span></span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $rec->status }}">
                                @if($rec->status === 'reading') Leyendo
                                @elseif($rec->status === 'completed') Completado
                                @elseif($rec->status === 'want_to_read') Por leer
                                @else {{ ucfirst($rec->status) }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $rec->started_at ? Carbon\Carbon::parse($rec->started_at)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $rec->finished_at ? Carbon\Carbon::parse($rec->finished_at)->format('d/m/Y') : '-' }}</td>
                        @if($isAdmin)
                            <td>{{ $rec->user->name ?? '-' }}</td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ $isAdmin ? 9 : 8 }}" style="text-align:center; color:#64748b;">No hay registros para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="footer">
        Gestor de Lectura &mdash; Total registros: {{ $total }}
    </div>
</body>
</html>
