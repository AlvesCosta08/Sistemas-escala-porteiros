@extends('layouts.app')

@section('title', 'Meu Perfil')
@section('header', 'Meu Perfil')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 h-32"></div>
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="flex items-end gap-6">
                    <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-200 shadow-md overflow-hidden">
                        @if(auth()->user()->foto_thumb_path)
                            <img src="{{ auth()->user()->fotoThumbUrl() }}" alt="Foto de Perfil" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl font-bold text-gray-400">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="pb-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="pb-1">
                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ auth()->user()->cargo }}
                    </span>
                </div>
            </div>
            <hr class="border-gray-100 my-6">
            <div class="max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Atualizar Foto de Perfil</h3>
                <p class="text-sm text-gray-500 mb-4">Envie uma foto nítida do seu rosto. Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB.</p>
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('perfil.foto.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <input type="file" name="foto" required accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors">Salvar Nova Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
