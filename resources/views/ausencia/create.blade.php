@extends('layouts.app')

@section('title', 'Aviso de Ausência')
@section('header', 'Avisar Ausência')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('minha-escala') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-xl md:text-2xl font-bold text-slate-800">Justificar Ausência</h2>
    </div>

    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 mb-6 shadow-sm">
        <p class="text-xs md:text-sm text-indigo-800 font-semibold mb-1">Você está avisando que não comparecerá no plantão:</p>
        <p class="text-base md:text-lg text-indigo-900 font-bold">
            {{ \Carbon\Carbon::parse($alocacao->data)->format('d/m/Y') }} - {{ $alocacao->posto->nome }} ({{ $alocacao->turno->nome }})
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-8">
        @if ($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 mb-6 rounded text-sm">
                <ul class="list-disc list-inside font-medium">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ausencia.store', $alocacao) }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Motivo da Ausência</label>
                <select name="motivo" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Selecione um motivo...</option>
                    <option value="doenca" {{ old('motivo') == 'doenca' ? 'selected' : '' }}>Atestado Médico / Doença</option>
                    <option value="imprevisto" {{ old('motivo') == 'imprevisto' ? 'selected' : '' }}>Imprevisto Pessoal/Familiar</option>
                    <option value="transporte" {{ old('motivo') == 'transporte' ? 'selected' : '' }}>Problemas de Transporte</option>
                    <option value="outros" {{ old('motivo') == 'outros' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Observações (Opcional)</label>
                <textarea name="observacao" rows="4" placeholder="Descreva brevemente o ocorrido..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('observacao') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse md:flex-row justify-end gap-3">
                <a href="{{ route('minha-escala') }}" class="w-full md:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-6 rounded-xl transition-colors text-sm">
                    Cancelar
                </a>
                <button type="submit" class="w-full md:w-auto bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-colors btn-interactive text-sm">
                    Confirmar Ausência
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
