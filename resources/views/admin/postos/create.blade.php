@extends('layouts.app')

@section('title', 'Novo Posto')
@section('header', 'Novo Posto')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('admin.postos.store') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Nome do Posto</label>
            <input type="text" name="nome" value="{{ old('nome') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-8">
            <label class="block text-sm font-bold text-gray-700 mb-2">Descrição (Opcional)</label>
            <input type="text" name="descricao" value="{{ old('descricao') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.postos.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md">Salvar Posto</button>
        </div>
    </form>
</div>
@endsection
