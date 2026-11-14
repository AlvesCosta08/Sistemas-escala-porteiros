@extends('layouts.app')

@section('title', 'Postos')
@section('header', 'Postos de Trabalho')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Locais onde os colaboradores exercem suas funções.</p>
        <a href="{{ route('admin.postos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
            + Novo Posto
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal border-b border-gray-200">
                    <th class="py-3 px-4 font-semibold">Nome do Posto</th>
                    <th class="py-3 px-4 font-semibold">Descrição</th>
                    <th class="py-3 px-4 font-semibold text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($postos as $posto)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 font-medium">{{ $posto->nome }}</td>
                    <td class="py-3 px-4">{{ $posto->descricao ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.postos.edit', $posto) }}" class="text-orange-500 hover:text-orange-700 font-semibold text-xs">Editar</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-6 text-center text-gray-500">Nenhum posto cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $postos->links() }}</div>
</div>
@endsection
