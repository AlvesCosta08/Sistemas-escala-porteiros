@extends('layouts.app')

@section('title', 'Minha escala')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Minha escala</h1>

    @forelse ($alocacoes as $alocacao)
        <article class="mb-3 rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-start gap-3">
                <x-avatar :user="$alocacao->user" size="h-12 w-12" />

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold">{{ $alocacao->user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $alocacao->posto->nome }}</p>
                    <p class="text-xs text-slate-500">
                        {{ $alocacao->data->isoFormat('ddd, DD/MM') }} ·
                        {{ substr($alocacao->turno->hora_inicio, 0, 5) }}–{{ substr($alocacao->turno->hora_fim, 0, 5) }}
                    </p>
                </div>
            </div>

            @if ($alocacao->status === 'confirmado')
                <a href="{{ route('ausencia.create', $alocacao) }}"
                   class="mt-3 block rounded-lg border border-red-300 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-50">
                    Não poderei comparecer
                </a>
            @endif
        </article>
    @empty
        <p class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow-sm">
            Nenhuma alocação neste mês.
        </p>
    @endforelse
@endsection