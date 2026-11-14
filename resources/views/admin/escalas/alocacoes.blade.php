@extends('layouts.app')

@section('title', 'Alocações')
@section('header', 'Alocações da Escala')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Gerenciar Plantões</h3>
            <p class="text-gray-500 text-sm mt-1">Mês: <strong class="text-blue-600">{{ $escala->mes_referencia }}</strong></p>
        </div>
        <a href="{{ route('admin.escalas.gerenciar') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg text-sm transition-colors">
            &larr; Voltar às Escalas
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de Alocação -->
    <form action="{{ route('admin.escalas.alocacoes.store', $escala) }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-gray-50 p-5 rounded-xl border border-gray-200 mb-8 items-end">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Colaborador</label>
            <select name="user_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                @foreach($colaboradores as $colab)
                    <option value="{{ $colab->id }}" {{ old('user_id') == $colab->id ? 'selected' : '' }}>{{ $colab->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Posto</label>
            <select name="posto_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                @foreach($postos as $posto)
                    <option value="{{ $posto->id }}" {{ old('posto_id') == $posto->id ? 'selected' : '' }}>{{ $posto->nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Turno</label>
            <select name="turno_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                @foreach($turnos as $turno)
                    <option value="{{ $turno->id }}" {{ old('turno_id') == $turno->id ? 'selected' : '' }}>{{ $turno->nome }} ({{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Data</label>
            <input type="date" name="data" value="{{ old('data') }}" min="{{ $escala->mes_referencia }}-01" max="{{ \Carbon\Carbon::parse($escala->mes_referencia . '-01')->endOfMonth()->format('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg text-sm shadow-md transition-all">
                Alocar
            </button>
        </div>
    </form>

    <!-- Tabela de Alocações -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs border-b border-gray-200">
                    <th class="py-3 px-4 font-bold">Data</th>
                    <th class="py-3 px-4 font-bold">Colaborador</th>
                    <th class="py-3 px-4 font-bold">Posto</th>
                    <th class="py-3 px-4 font-bold">Turno</th>
                    <th class="py-3 px-4 font-bold">Status</th>
                    <th class="py-3 px-4 font-bold text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($alocacoes as $alocacao)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 font-semibold text-gray-800">{{ \Carbon\Carbon::parse($alocacao->data)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ $alocacao->user->name }}</td>
                    <td class="py-3 px-4">{{ $alocacao->posto->nome }}</td>
                    <td class="py-3 px-4">{{ $alocacao->turno->nome }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ ucfirst($alocacao->status) }}</span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.escalas.alocacoes.destroy', [$escala, $alocacao]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors" onclick="return confirm('Tem certeza que deseja remover esta alocação?')">Remover</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">Nenhuma alocação feita nesta escala ainda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-6">
        {{ $alocacoes->links() }}
    </div>
</div>
@endsection
