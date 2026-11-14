@extends('layouts.app')
@section('title', 'Alocações')
@section('header', 'Alocações da Escala')
@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6 card-hover">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-slate-100 pb-4 gap-4">
        <div>
            <h3 class="text-lg md:text-xl font-bold text-slate-800">Gerenciar Plantões</h3>
            <p class="text-slate-500 text-sm mt-1">Mês: <strong class="text-indigo-600">{{ $escala->mes_referencia }}</strong></p>
        </div>
        <a href="{{ route('admin.escalas.gerenciar') }}" class="w-full md:w-auto text-center inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-lg text-sm transition-colors">
            &larr; Voltar às Escalas
        </a>
    </div>
    
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-sm">
            <ul class="list-disc list-inside font-medium text-sm">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.escalas.alocacoes.store', $escala) }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-slate-50 p-4 md:p-5 rounded-xl border border-slate-200 mb-8 items-end">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Colaborador</label>
            <select name="user_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                <option value="">Selecione...</option>
                @foreach($colaboradores as $colab) <option value="{{ $colab->id }}">{{ $colab->name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Posto</label>
            <select name="posto_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                <option value="">Selecione...</option>
                @foreach($postos as $posto) <option value="{{ $posto->id }}">{{ $posto->nome }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Turno</label>
            <select name="turno_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                <option value="">Selecione...</option>
                @foreach($turnos as $turno) <option value="{{ $turno->id }}">{{ $turno->nome }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Data</label>
            <input type="date" name="data" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
        </div>
        <div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-lg btn-interactive text-sm shadow-indigo-500/30">Alocar</button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-4 px-2 md:px-4 font-bold rounded-tl-xl">Data</th>
                    <th class="py-4 px-2 md:px-4 font-bold">Colaborador</th>
                    <th class="hidden md:table-cell py-4 px-4 font-bold">Posto / Turno</th>
                    <th class="py-4 px-2 md:px-4 font-bold text-center rounded-tr-xl">Ações</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 text-sm divide-y divide-slate-100">
                @forelse($alocacoes as $alocacao)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="py-4 px-2 md:px-4 font-bold text-slate-800">{{ \Carbon\Carbon::parse($alocacao->data)->format('d/m/Y') }}</td>
                    <td class="py-4 px-2 md:px-4 font-medium">{{ $alocacao->user->name }}</td>
                    <td class="hidden md:table-cell py-4 px-4">
                        <div class="text-xs text-slate-500 font-semibold">{{ $alocacao->posto->nome }}</div>
                        <div class="text-xs">{{ $alocacao->turno->nome }}</div>
                    </td>
                    <td class="py-4 px-2 md:px-4 text-center">
                        <form action="{{ route('admin.escalas.alocacoes.destroy', [$escala, $alocacao]) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg font-bold text-xs transition-colors" onclick="return confirm('Remover esta alocação?')">Remover</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-12 text-center text-slate-400 font-medium">Nenhuma alocação feita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $alocacoes->links() }}</div>
</div>
@endsection
