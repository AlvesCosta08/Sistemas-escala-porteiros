@extends('layouts.app')

@section('title', 'Colaboradores')
@section('header', 'Gerenciar Colaboradores')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Lista de todos os funcionários cadastrados no sistema.</p>
        <a href="{{ route('admin.usuarios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
            + Novo Colaborador
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal border-b border-gray-200">
                    <th class="py-3 px-4 font-semibold">Nome</th>
                    <th class="py-3 px-4 font-semibold">E-mail</th>
                    <th class="py-3 px-4 font-semibold">Cargo</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            @if($user->foto_thumb_path)
                                <img class="w-8 h-8 rounded-full mr-3 object-cover" src="{{ Storage::disk('public')->url($user->foto_thumb_path) }}" alt="">
                            @else
                                <div class="w-8 h-8 rounded-full mr-3 bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        @php
                            $badgeColor = match($user->cargo) {
                                'admin' => 'bg-red-100 text-red-700',
                                'porteiro' => 'bg-blue-100 text-blue-700',
                                'recepcionista' => 'bg-purple-100 text-purple-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                            {{ ucfirst($user->cargo) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $user->active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.usuarios.edit', $user) }}" class="text-orange-500 hover:text-orange-700 font-semibold mr-3 text-xs">Editar</a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.usuarios.toggle', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">
                                {{ $user->active ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
