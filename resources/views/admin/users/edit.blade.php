@extends('layouts.app')

@section('title', 'Editar Colaborador')
@section('header', 'Editar Colaborador')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Mostra erros de validação globais (como arquivo muito grande) -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-sm">
            <ul class="list-disc list-inside text-sm font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SEÇÃO DA FOTO DE PERFIL -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row items-center gap-8">
        <div class="shrink-0">
            @if($user->foto_thumb_path)
                <!-- O ?v=timestamp força o navegador a não usar cache da imagem antiga -->
                <img src="{{ Storage::disk('public')->url($user->foto_thumb_path) }}?v={{ time() }}" alt="Foto de {{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
            @else
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-4xl font-bold text-gray-400 border-4 border-white shadow-lg">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
        </div>
        
        <div class="flex-1 w-full">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Foto de Perfil</h3>
            <p class="text-sm text-gray-500 mb-4">Envie uma foto nítida. Formatos: JPG, PNG. Tamanho máximo: 2MB.</p>
            
            <form action="{{ route('admin.usuarios.foto.update', $user) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="file" name="foto" required accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors cursor-pointer border border-gray-200 rounded-lg bg-gray-50">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors whitespace-nowrap">
                    Atualizar Foto
                </button>
            </form>
        </div>
    </div>

    <!-- SEÇÃO DOS DADOS CADASTRAIS -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b border-gray-100 pb-2">Dados Cadastrais</h3>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nome Completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Cargo / Função</label>
                <select name="cargo" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    <option value="porteiro" {{ old('cargo', $user->cargo) == 'porteiro' ? 'selected' : '' }}>Porteiro</option>
                    <option value="recepcionista" {{ old('cargo', $user->cargo) == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                    <option value="admin" {{ old('cargo', $user->cargo) == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nova Senha (Opcional)</label>
                <input type="password" name="password" minlength="6" placeholder="Deixe em branco para manter a atual" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-8 flex items-center">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $user->active) ? 'checked' : '' }} {{ auth()->id() === $user->id ? 'disabled' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="active" class="ml-2 text-sm font-bold text-gray-700">Usuário Ativo</label>
                @if(auth()->id() === $user->id)
                    <span class="ml-2 text-xs text-gray-500">(Você não pode desativar a si mesmo)</span>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
@endsection