@extends('layouts.app')

@section('title', 'Aviso de Ausência')
@section('header', 'Avisar Ausência')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('minha-escala') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Justificar Ausência</h2>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <p class="text-sm text-blue-800 font-semibold mb-1">Você está avisando que não comparecerá no plantão:</p>
        <p class="text-lg text-blue-900 font-bold">
            {{ \Carbon\Carbon::parse($alocacao->data)->format('d/m/Y') }} - {{ $alocacao->posto->nome }} ({{ $alocacao->turno->nome }})
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ausencia.store', $alocacao) }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo da Ausência</label>
                <select name="motivo" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione um motivo...</option>
                    <option value="doenca" {{ old('motivo') == 'doenca' ? 'selected' : '' }}>Atestado Médico / Doença</option>
                    <option value="imprevisto" {{ old('motivo') == 'imprevisto' ? 'selected' : '' }}>Imprevisto Pessoal/Familiar</option>
                    <option value="transporte" {{ old('motivo') == 'transporte' ? 'selected' : '' }}>Problemas de Transporte</option>
                    <option value="outros" {{ old('motivo') == 'outros' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Observações (Opcional)</label>
                <textarea name="observacao" rows="4" placeholder="Descreva brevemente o ocorrido (se necessário)..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('observacao') }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('minha-escala') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors">
                    Confirmar Ausência
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
