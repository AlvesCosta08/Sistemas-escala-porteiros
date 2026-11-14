@extends('layouts.app')

@section('title', 'Gestão de Escalas')
@section('header', 'Gestão de Escalas')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 card-hover">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Crie e publique escalas mensais.</p>
        <a href="{{ route('admin.escalas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl btn-interactive text-sm">
            Ver Calendário Visual
        </a>
    </div>

    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5 mb-6 shadow-inner">
        <form action="{{ route('admin.escalas.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mês de Referência</label>
                <input type="month" name="mes_referencia" required class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-52 shadow-sm transition-all">
                @error('mes_referencia') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg btn-interactive text-sm shadow-blue-500/30 h-[42px]">
                Criar Escala
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                    <th class="py-4 px-4 font-bold rounded-tl-xl">Mês Referência</th>
                    <th class="py-4 px-4 font-bold">Status</th>
                    <th class="py-4 px-4 font-bold text-center rounded-tr-xl">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($escalas as $escala)
                <tr class="border-b border-gray-100 hover:bg-blue-50/50 transition-colors duration-200 group">
                    <td class="py-4 px-4 font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                        @php
                            $meses = ['01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março','04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto','09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro'];
                            $ano = substr($escala->mes_referencia, 0, 4);
                            $mes = substr($escala->mes_referencia, 5, 2);
                        @endphp
                        {{ $meses[$mes] ?? $mes }}/{{ $ano }}
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $escala->status === 'publicada' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ ucfirst($escala->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center space-x-4">
                        <a href="{{ route('admin.escalas.alocacoes.index', $escala) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs transition-colors">Gerenciar Alocações</a>
                        @if($escala->status === 'rascunho')
                        <form action="{{ route('admin.escalas.publicar', $escala) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-orange-500 hover:text-orange-700 font-bold text-xs transition-colors">Publicar</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-gray-400">Nenhuma escala cadastrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $escalas->links() }}</div>
</div>
@endsection
