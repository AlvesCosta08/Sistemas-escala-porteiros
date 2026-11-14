@extends('layouts.app')

@section('title', 'Minha Escala')
@section('header', 'Minha Escala de Trabalho')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <p class="text-gray-600">Confira abaixo os seus plantões agendados. Se não puder comparecer, avise com antecedência.</p>
    </div>

    <div class="grid gap-4">
        @forelse($alocacoes as $alocacao)
            <div class="bg-white rounded-xl shadow-sm border-l-4 {{ $alocacao->status === 'pendente' ? 'border-orange-400' : 'border-blue-500' }} p-5 flex flex-col md:flex-row justify-between items-center gap-4">
                
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="text-center bg-gray-50 rounded-lg p-3 min-w-[80px] border border-gray-100">
                        <span class="block text-xs font-bold text-gray-500 uppercase">{{ \Carbon\Carbon::parse($alocacao->data)->translatedFormat('M') }}</span>
                        <span class="block text-2xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($alocacao->data)->format('d') }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $alocacao->posto->nome }}</h3>
                        <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $alocacao->turno->nome }} ({{ \Carbon\Carbon::parse($alocacao->turno->hora_inicio)->format('H:i') }} às {{ \Carbon\Carbon::parse($alocacao->turno->hora_fim)->format('H:i') }})
                        </p>
                    </div>
                </div>

                <div class="w-full md:w-auto flex justify-end">
                    @if($alocacao->status === 'confirmado')
                        <a href="{{ route('ausencia.create', $alocacao) }}" class="w-full md:w-auto text-center border border-red-500 text-red-500 hover:bg-red-50 font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                            Não poderei comparecer
                        </a>
                    @else
                        <span class="inline-block bg-orange-100 text-orange-700 font-bold px-3 py-2 rounded-lg text-sm w-full md:w-auto text-center">
                            Ausência Solicitada
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm p-10 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-gray-500 text-lg">Você não possui plantões agendados no momento.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
