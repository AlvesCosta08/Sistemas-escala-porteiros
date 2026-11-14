<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alocações - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; margin: 0; }
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.9rem; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-size: 0.85rem; color: #6b7280; text-transform: uppercase; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.875rem; cursor: pointer; border: none; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-danger { background: #ef4444; color: white; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .form-box { display: grid; grid-template-columns: 2fr 2fr 2fr 2fr 1fr; gap: 1rem; margin-top: 1rem; background: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid #e5e7eb; align-items: end; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #374151; font-size: 0.85rem; }
        select, input { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Alocações da Escala</h1>
                <p style="color: #6b7280; margin: 0;">Mês: <strong>{{ $escala->mes_referencia }}</strong></p>
            </div>
            <a href="{{ route('admin.escalas.index') }}" class="btn btn-secondary">Voltar às Escalas</a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.escalas.alocacoes.store', $escala) }}" method="POST" class="form-box">
            @csrf
            <div>
                <label>Colaborador</label>
                <select name="user_id" required>
                    <option value="">Selecione...</option>
                    @foreach($colaboradores as $colab)
                        <option value="{{ $colab->id }}" {{ old('user_id') == $colab->id ? 'selected' : '' }}>{{ $colab->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Posto</label>
                <select name="posto_id" required>
                    <option value="">Selecione...</option>
                    @foreach($postos as $posto)
                        <option value="{{ $posto->id }}" {{ old('posto_id') == $posto->id ? 'selected' : '' }}>{{ $posto->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Turno</label>
                <select name="turno_id" required>
                    <option value="">Selecione...</option>
                    @foreach($turnos as $turno)
                        <option value="{{ $turno->id }}" {{ old('turno_id') == $turno->id ? 'selected' : '' }}>{{ $turno->nome }} ({{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Data</label>
                <input type="date" name="data" value="{{ old('data') }}" min="{{ $escala->mes_referencia }}-01" max="{{ \Carbon\Carbon::parse($escala->mes_referencia . '-01')->endOfMonth()->format('Y-m-d') }}" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Alocar</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Colaborador</th>
                    <th>Posto</th>
                    <th>Turno</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alocacoes as $alocacao)
                <tr>
                    <td><strong>{{ \Carbon\Carbon::parse($alocacao->data)->format('d/m/Y') }}</strong></td>
                    <td>{{ $alocacao->user->name }}</td>
                    <td>{{ $alocacao->posto->nome }}</td>
                    <td>{{ $alocacao->turno->nome }}</td>
                    <td>{{ ucfirst($alocacao->status) }}</td>
                    <td>
                        <form action="{{ route('admin.escalas.alocacoes.destroy', [$escala, $alocacao]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover esta alocação?')">Remover</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhuma alocação feita nesta escala ainda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1.5rem;">{{ $alocacoes->links() }}</div>
    </div>
</body>
</html>
