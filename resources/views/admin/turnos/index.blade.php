@extends('layouts.app')

@section('title', 'Turnos')
@section('header', 'Turnos de Trabalho')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6 card-hover">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <p class="text-slate-500 text-sm">Horários e regras de intervalo das escalas.</p>
        <a href="{{ route('admin.turnos.create') }}" class="w-full md:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl btn-interactive text-sm shadow-indigo-500/30">
            + Novo Turno
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-4 px-2 md:px-4 font-bold rounded-tl-xl">Nome</th>
                    <th class="py-4 px-2 md:px-4 font-bold">Horário</th>
                    <th class="hidden md:table-cell py-4 px-4 font-bold">Regras</th>
                    <th class="py-4 px-2 md:px-4 font-bold text-center rounded-tr-xl">Ações</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 text-sm divide-y divide-slate-100">
                @forelse($turnos as $turno)
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="py-4 px-2 md:px-4 font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $turno->nome }}</td>
                    <td class="py-4 px-2 md:px-4 text-xs md:text-sm">
                        {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }} às {{ \Carbon\Carbon::parse($turno->hora_fim)->format('H:i') }}
                    </td>
                    <td class="hidden md:table-cell py-4 px-4 text-xs">
                        <span class="block">Tolerância: {{ $turno->tolerancia_atraso_min }} min</span>
                        <span class="block">Intervalo: {{ $turno->intervalo_min }} min</span>
                    </td>
                    <td class="py-4 px-2 md:px-4 text-center">
                        <a href="{{ route('admin.turnos.edit', $turno) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs transition-colors">Editar</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-8 text-center text-slate-400">Nenhum turno cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $turnos->links() }}</div>
</div>
@endsection
