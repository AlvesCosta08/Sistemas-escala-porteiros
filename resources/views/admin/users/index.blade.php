<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Colaboradores - Obede</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; padding: 2rem; margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
        h1 { color: #111827; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: 0.75rem; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-size: 0.85rem; color: #6b7280; text-transform: uppercase; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.875rem; cursor: pointer; border: none; display: inline-block; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-edit { background: #f59e0b; color: white; }
        .btn-toggle { background: #ef4444; color: white; }
        .btn-toggle.active { background: #10b981; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #34d399; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; }
        .badge { padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .badge-admin { background: #fee2e2; color: #991b1b; }
        .badge-porteiro { background: #dbeafe; color: #1e40af; }
        .badge-recepcionista { background: #fce7f3; color: #9d174d; }
        .status-ativo { color: #059669; font-weight: bold; }
        .status-inativo { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gerenciar Colaboradores</h1>
            <div>
                <a href="{{ route('admin.ausencias.index') }}" class="btn btn-secondary">Voltar ao Painel</a>
                <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">+ Novo Colaborador</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cargo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->cargo }}">{{ ucfirst($user->cargo) }}</span>
                    </td>
                    <td>
                        <span class="{{ $user->active ? 'status-ativo' : 'status-inativo' }}">
                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $user) }}" class="btn btn-edit">Editar</a>
                        
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.usuarios.toggle', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-toggle {{ $user->active ? 'active' : '' }}">
                                {{ $user->active ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #6b7280;">Nenhum colaborador cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 1.5rem;">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>