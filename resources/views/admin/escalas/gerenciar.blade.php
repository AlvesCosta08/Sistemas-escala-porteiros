@extends('layouts.app')

@section('title', 'Gestão de Escalas')
@section('header', 'Gestão de Escalas')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6 card-hover">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <p class="text-slate-500 text-sm">Crie e publique escalas mensais.</p>
        <a href="{{ route('admin.escalas.index') }}" class="w-full md:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-xl btn-interactive text-sm transition-colors">
            Ver Calendário Visual
        </a>
    </div>

    <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 md:p-5 mb-8 shadow-inner">
        <form action="{{ route('admin.escalas.store') }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
            @csrf
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mês de Referência</label>
                <input type="month" name="mes_referencia" required class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-52 shadow-sm transition-all">
                @error('mes_referencia') <div class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg btn-interactive text-sm shadow-indigo-500/30 h-[38px]">
                Criar Escala
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider border-b border-slate-200">
                    <th class="py-4 px-2 md:px-4 font-bold rounded-tl-xl">Mês Referência</th>
                    <th class="py-4 px-2 md:px-4 font-bold">Status</th>
                    <th class="py-4 px-2 md:px-4 font-bold text-center rounded-tr-xl">Ações</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 text-sm divide-y divide-slate-100">
                @forelse($escalas as $escala)
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="py-4 px-2 md:px-4 font-bold text-slate-800 group-hover:text-indigo-600 transition-colors whitespace-nowrap">
                        @php
                            $meses = [
                                '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',
                                '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
                                '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro',
                                '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
                            ];
                            $ano = substr($escala->mes_referencia, 0, 4);
                            $mes = substr($escala->mes_referencia, 5, 2);
                        @endphp
                        {{ $meses[$mes] ?? $mes }}/{{ $ano }}
                    </td>
                    <td class="py-4 px-2 md:px-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset {{ $escala->status === 'publicada' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-amber-50 text-amber-700 ring-amber-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $escala->status === 'publicada' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ ucfirst($escala->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-2 md:px-4 text-center space-y-2 md:space-y-0 md:space-x-3 whitespace-nowrap">
                        <a href="{{ route('admin.escalas.alocacoes.index', $escala) }}" class="inline-block text-indigo-600 hover:text-indigo-800 font-bold text-xs transition-colors">Alocações</a>
                        @if($escala->status === 'rascunho')
                        <form action="{{ route('admin.escalas.publicar', $escala) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-block text-amber-600 hover:text-amber-800 font-bold text-xs transition-colors">Publicar</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="py-8 text-center text-slate-400">Nenhuma escala cadastrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $escalas->links() }}</div>
</div>
@endsection
