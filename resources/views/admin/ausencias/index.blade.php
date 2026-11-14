@extends('layouts.app')

@section('title', 'Ausências pendentes')

@section('content')
    <h1 class="mb-4 text-xl font-bold">
        Ausências pendentes ({{ $avisos->count() }})
    </h1>

    @forelse ($avisos as $aviso)
        <article class="mb-3 rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-start gap-3">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-600">
                    {{ mb_substr($aviso->user->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold">{{ $aviso->user->name }}</p>
                    <p class="text-xs text-slate-500">
                        {{ $aviso->alocacao->posto->nome }} ·
                        {{ $aviso->alocacao->data->isoFormat('ddd, DD/MM') }} ·
                        {{ substr($aviso->alocacao->turno->hora_inicio, 0, 5) }}–{{ substr($aviso->alocacao->turno->hora_fim, 0, 5) }}
                    </p>
                    <p class="text-xs text-slate-500">
                        Motivo: {{ $aviso->motivoRotulo() }}
                    </p>
                </div>
                @if ($aviso->urgente)
                    <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                        Urgente
                    </span>
                @endif
            </div>
        </article>
    @empty
        <p class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 shadow-sm">
            Nenhuma ausência pendente. 🎉
        </p>
    @endforelse
@endsection