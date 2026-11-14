@extends('layouts.app')

@section('title', 'Colaboradores')
@section('header', 'Gerenciar Colaboradores')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6 card-hover">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Equipe</h3>
            <p class="text-slate-500 text-sm mt-1">Gerencie os acessos e cargos da equipe.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="w-full md:w-auto text-center inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl btn-interactive text-sm shadow-indigo-500/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Colaborador
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-4 px-2 md:px-4 font-bold rounded-tl-xl">Colaborador</th>
                    <th class="hidden md:table-cell py-4 px-4 font-bold">E-mail</th>
                    <th class="hidden md:table-cell py-4 px-4 font-bold">Cargo</th>
                    <th class="py-4 px-2 md:px-4 font-bold">Status</th>
                    <th class="py-4 px-2 md:px-4 font-bold text-center rounded-tr-xl">Ações</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 text-sm divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                    <td class="py-4 px-2 md:px-4">
                        <div class="flex items-center">
                            @if($user->foto_thumb_path)
                                <img class="w-10 h-10 rounded-full mr-3 object-cover shadow-sm border-2 border-white ring-1 ring-slate-200" src="{{ $user->fotoThumbUrl() }}" alt="">
                            @else
                                <div class="w-10 h-10 rounded-full mr-3 bg-slate-100 flex items-center justify-center shadow-sm border-2 border-white ring-1 ring-slate-200 text-slate-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    <span class="hidden">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <span class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="hidden md:table-cell py-4 px-4 font-medium">{{ $user->email }}</td>
                    <td class="hidden md:table-cell py-4 px-4">
                        @php
                            $badgeColor = match($user->cargo) {
                                'admin' => 'bg-purple-100 text-purple-700 ring-purple-200',
                                'porteiro' => 'bg-blue-100 text-blue-700 ring-blue-200',
                                'recepcionista' => 'bg-cyan-100 text-cyan-700 ring-cyan-200',
                                default => 'bg-slate-100 text-slate-700 ring-slate-200',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset {{ $badgeColor }}">
                            {{ ucfirst($user->cargo) }}
                        </span>
                    </td>
                    <td class="py-4 px-2 md:px-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset {{ $user->active ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-500 ring-slate-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            {{ $user->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="py-4 px-2 md:px-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.usuarios.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.usuarios.toggle', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    {{ $user->active ? 'Desativar' : 'Ativar' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
