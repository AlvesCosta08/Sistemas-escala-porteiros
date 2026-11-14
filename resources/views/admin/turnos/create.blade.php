<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Turno - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #374151; font-size: 0.9rem; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: bold; text-decoration: none; border: none; display: inline-block; margin-top: 1rem; cursor: pointer; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-cancel { background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Novo Turno</h1>
        @if ($errors->any())
            <div style="color: #991b1b; margin-bottom: 1rem;"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.turnos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nome do Turno (ex: Diurno, Madrugada)</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required>
            </div>
            
            <div class="grid">
                <div class="form-group">
                    <label>Hora de Início</label>
                    <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
                </div>
                <div class="form-group">
                    <label>Hora de Fim</label>
                    <input type="time" name="hora_fim" value="{{ old('hora_fim') }}" required>
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Tolerância de Atraso (min)</label>
                    <input type="number" name="tolerancia_atraso_min" value="{{ old('tolerancia_atraso_min', 10) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label>Intervalo (min)</label>
                    <input type="number" name="intervalo_min" value="{{ old('intervalo_min', 60) }}" min="0" required>
                </div>
            </div>

            <a href="{{ route('admin.turnos.index') }}" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Turno</button>
        </form>
    </div>
</body>
</html>
