<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Turnos - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; margin: 0; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-size: 0.85rem; color: #6b7280; text-transform: uppercase; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.875rem; cursor: pointer; border: none; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-edit { background: #f59e0b; color: white; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Turnos de Trabalho</h1>
            <div>
                <a href="{{ route('admin.postos.index') }}" class="btn btn-secondary">Gerenciar Postos</a>
                <a href="{{ route('admin.turnos.create') }}" class="btn btn-primary">+ Novo Turno</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Tolerância</th>
                    <th>Intervalo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($turnos as $turno)
                <tr>
                    <td><strong>{{ $turno->nome }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($turno->hora_fim)->format('H:i') }}</td>
                    <td>{{ $turno->tolerancia_atraso_min }} min</td>
                    <td>{{ $turno->intervalo_min }} min</td>
                    <td>
                        <a href="{{ route('admin.turnos.edit', $turno) }}" class="btn btn-edit">Editar</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center;">Nenhum turno cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1.5rem;">{{ $turnos->links() }}</div>
    </div>
</body>
</html>