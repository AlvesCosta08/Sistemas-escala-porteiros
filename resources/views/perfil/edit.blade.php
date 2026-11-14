@extends('layouts.app')

@section('title', 'Meu perfil')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Meu perfil</h1>

    <section class="mb-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
        <div class="flex items-center gap-4">
            <x-avatar :user="$user" size="h-16 w-16" />
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
                <p class="text-xs text-slate-500">{{ ucfirst($user->cargo) }}</p>
                <p class="text-xs text-slate-500">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('perfil.foto.update') }}"
              enctype="multipart/form-data"
              class="mt-4 space-y-2 border-t border-slate-100 pt-4">
            @csrf
            <label for="foto" class="block text-sm font-medium">
                Trocar foto (JPG, PNG ou WEBP · máx. 2 MB)
            </label>
            <input id="foto" type="file" name="foto"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="w-full text-sm">
            @error('foto')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit"
                    class="w-full rounded-lg bg-slate-900 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Salvar foto
            </button>
        </form>
    </section>

    <a href="{{ route('dashboard') }}"
       class="text-sm text-slate-500 hover:text-slate-800">
        ← Voltar
    </a>
@endsection