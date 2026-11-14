<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Escalas - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; margin: 0; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-size: 0.85rem; color: #6b7280; text-transform: uppercase; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.875rem; cursor: pointer; border: none; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-warning { background: #f59e0b; color: white; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .badge { padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .badge-rascunho { background: #f3f4f6; color: #374151; }
        .badge-publicada { background: #d1fae5; color: #065f46; }
        .form-inline { display: flex; gap: 1rem; align-items: flex-end; margin-top: 1rem; background: #f9fafb; padding: 1rem; border-radius: 8px; border: 1px solid #e5e7eb; }
        .form-group { margin: 0; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #374151; font-size: 0.85rem; }
        input { padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Escalas</h1>
            <div>
                <a href="{{ route('admin.escalas.index') }}" class="btn btn-secondary">Ver Calendário</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-inline">
            <form action="{{ route('admin.escalas.store') }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end;">
                @csrf
                <div class="form-group">
                    <label>Criar Escala para o Mês:</label>
                    <input type="month" name="mes_referencia" required>
                    @error('mes_referencia') <div style="color:red; font-size:0.8rem;">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Criar Escala</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mês Referência</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($escalas as $escala)
                <tr>
                    <td>
                        <strong>
                            @php
                                $meses = [
                                    '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',
                                    '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
                                    '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro',
                                    '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
                                ];
                                $ano = substr($escala->mes_referencia, 0, 4);
                                $mes = substr($escala->mes_referencia, 5, 2);
                            @endphp
                            {{ $meses[$mes] ?? $mes }}/{{ $ano }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge badge-{{ $escala->status }}">{{ ucfirst($escala->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.escalas.alocacoes.index', $escala) }}" class="btn btn-primary" style="margin-right: 10px;">Gerenciar Alocações</a>
                        @if($escala->status === 'rascunho')
                        <form action="{{ route('admin.escalas.publicar', $escala) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning">Publicar Escala</button>
                        </form>
                        @else
                        <span style="color: #059669; font-size: 0.85rem; font-weight: bold;">✓ Publicada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Nenhuma escala cadastrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1.5rem;">{{ $escalas->links() }}</div>
    </div>
</body>
</html>
