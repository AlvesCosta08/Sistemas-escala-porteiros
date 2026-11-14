@extends('layouts.app')

@section('title', 'Novo Turno')
@section('header', 'Novo Turno')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('admin.turnos.store') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nome do Turno (ex: Diurno)</label>
            <input type="text" name="nome" value="{{ old('nome') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Hora de Início</label>
                <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Hora de Fim</label>
                <input type="time" name="hora_fim" value="{{ old('hora_fim') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tolerância (min)</label>
                <input type="number" name="tolerancia_atraso_min" value="{{ old('tolerancia_atraso_min', 10) }}" min="0" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Intervalo (min)</label>
                <input type="number" name="intervalo_min" value="{{ old('intervalo_min', 60) }}" min="0" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.turnos.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md">Salvar Turno</button>
        </div>
    </form>
</div>
@endsection
