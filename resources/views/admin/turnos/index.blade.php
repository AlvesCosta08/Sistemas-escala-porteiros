@extends('layouts.app')

@section('title', 'Turnos')
@section('header', 'Turnos de Trabalho')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Horários e regras de intervalo das escalas.</p>
        <a href="{{ route('admin.turnos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
            + Novo Turno
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal border-b border-gray-200">
                    <th class="py-3 px-4 font-semibold">Nome</th>
                    <th class="py-3 px-4 font-semibold">Início</th>
                    <th class="py-3 px-4 font-semibold">Fim</th>
                    <th class="py-3 px-4 font-semibold">Tolerância</th>
                    <th class="py-3 px-4 font-semibold">Intervalo</th>
                    <th class="py-3 px-4 font-semibold text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($turnos as $turno)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 font-medium">{{ $turno->nome }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($turno->hora_fim)->format('H:i') }}</td>
                    <td class="py-3 px-4">{{ $turno->tolerancia_atraso_min }} min</td>
                    <td class="py-3 px-4">{{ $turno->intervalo_min }} min</td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.turnos.edit', $turno) }}" class="text-orange-500 hover:text-orange-700 font-semibold text-xs">Editar</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">Nenhum turno cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $turnos->links() }}</div>
</div>
@endsection
