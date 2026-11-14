<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Obede') — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <header class="sticky top-0 z-10 border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-md items-center justify-between px-4 py-3">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold">Obede</a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('perfil.edit') }}" class="text-slate-500 hover:text-slate-800">
                    Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-slate-800">
                        Sair
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-md px-4 py-4">
        @if (session('status'))
            <div class="mb-4 rounded-lg bg-emerald-50 px-3 py-2 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-8 pb-6 text-center text-xs text-slate-400">
        Obede — em memória de Obede-Edom (1 Crônicas 26).
    </footer>
</body>
</html>