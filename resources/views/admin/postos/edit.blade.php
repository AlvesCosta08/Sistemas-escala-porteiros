<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Posto - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #374151; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: bold; text-decoration: none; border: none; display: inline-block; margin-top: 1rem; cursor: pointer; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-cancel { background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Posto</h1>
        @if ($errors->any())
            <div style="color: #991b1b; margin-bottom: 1rem;"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.postos.update', $posto) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nome do Posto</label>
                <input type="text" name="nome" value="{{ old('nome', $posto->nome) }}" required>
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="descricao" value="{{ old('descricao', $posto->descricao) }}">
            </div>
            <a href="{{ route('admin.postos.index') }}" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-primary">Atualizar Posto</button>
        </form>
    </div>
</body>
</html>
